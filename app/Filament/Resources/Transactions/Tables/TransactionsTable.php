<?php

namespace App\Filament\Resources\Transactions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use App\Services\DokuPaymentService;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use App\Models\Delivery;
use App\Models\Courier; // Pastikan Model Courier ada

use Filament\Tables\Table;
use App\Models\Transaction; // Pastikan import model

class TransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // 1. Nama User (Pastikan relasi di Model Transaction bernama 'user', huruf kecil)
                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                // 2. Produk & Quantity (Digabung agar rapi)
                TextColumn::make('detailTransactions')
                    ->label('Items Purchased')
                    ->formatStateUsing(function ($record) {
                        return $record->detailTransactions->map(function ($detail) {
                            return "• {$detail->product_name} (x{$detail->quantity})";
                        })->implode('<br>');
                    })
                    ->html(),

                // 3. Total Harga
                TextColumn::make('total_amount')
                    ->numeric()
                    ->prefix('Rp ')
                    ->sortable(),

                // 4. Shipping Cost
                TextColumn::make('shipping_cost')
                    ->numeric()
                    ->prefix('Rp ')
                    ->sortable(),

                // 5. Status (Kode warna diperbaiki)
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending', 'processing', 'shipped' => 'warning',
                        'paid', 'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),

                // 6. Payment Method
                TextColumn::make('payment_method')
                    ->label('Payment')
                    ->badge()
                    ->color('info'),

                // 7. Transaction Date
                TextColumn::make('transaction_date')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('pay')
                    ->label('Bayar')
                    ->icon('heroicon-o-credit-card')
                    ->color('success') // Warna Hijau
                    ->openUrlInNewTab() // Agar Doku terbuka di tab baru
                    // Tombol hanya muncul jika status masih 'pending'
                    ->visible(fn($record) => $record->status === 'pending')
                    ->action(function ($record) {
                        try {
                            // 1. Cek apakah Link sudah pernah dibuat sebelumnya
                            if ($record->payment_url) {
                                return redirect()->away($record->payment_url);
                            }

                            // 2. Panggil Service (Koki) yang tadi dibuat
                            $service = new DokuPaymentService();
                            $url = $service->generatePaymentLink($record);

                            // 3. Redirect user ke halaman pembayaran Doku
                            return redirect()->away($url);

                        } catch (\Exception $e) {
                            // Munculkan notifikasi error di pojok kanan atas jika gagal
                            Notification::make()
                                ->title('Gagal memproses pembayaran')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
                Action::make('input_resi')
                    ->label('Update Pengiriman')
                    ->icon('heroicon-o-truck')
                    ->color('info') // Warna Biru
                    // Tombol hanya muncul jika status sudah 'paid' atau 'processing'
                    ->visible(fn($record) => in_array($record->status, ['paid', 'processing', 'shipped']))

                    // --- FORM MODAL (Pop-up) ---
                    ->form([
                        // 1. Pilih Kurir (Pastikan Anda punya tabel 'couriers')
                        // Jika belum punya tabel kurir, ganti Select ini jadi TextInput biasa
                        Select::make('courier_id')
                            ->label('Pilih Kurir')
                            ->options(Courier::all()->pluck('name', 'id')) // Ambil data dari tabel couriers
                            ->required(),

                        // 3. Status Pengiriman
                        Select::make('status')
                            ->options([
                                'preparing' => 'Sedang Dipersiapkan',
                                'shipped' => 'Dikirim (Shipped)',
                                'delivered' => 'Sampai Tujuan',
                            ])
                            ->default('shipped')
                            ->required(),

                        Textarea::make('delivery_address')
                            ->label('Alamat Pengiriman')
                            ->rows(3)
                            ->required()
                            // Bagian ini yang membuatnya AUTO FILL dari data User
                            ->default(fn($record) => $record->user->address ?? 'Alamat user tidak ditemukan')
                            ->columnSpanFull(),
                        Textarea::make('notes')
                            ->label('Catatan Tambahan (Opsional)'),
                    ])

                    // --- ISI DATA SAAT MODAL DIBUKA ---
                    ->mountUsing(function ($form, $record) {
                        // SKENARIO 1: Data pengiriman SUDAH ADA di database
                        if ($record->delivery) {
                            $form->fill([
                                'courier_id' => $record->delivery->courier_id,
                                'tracking_number' => $record->delivery->tracking_number,
                                'status' => $record->delivery->status,
                                'delivery_address' => $record->delivery->delivery_address, // Pakai alamat yang sudah disimpan
                                'notes' => $record->delivery->notes,
                            ]);
                        } 
                        // SKENARIO 2: Data pengiriman BELUM ADA (Baru mau input)
                        else {
                            $form->fill([
                                'status' => 'preparing',
                                // 👇 DISINI KITA AMBIL ALAMAT USER 👇
                                // Pastikan kolom di tabel users Anda bernama 'address'. Kalau 'alamat', ganti jadi ->alamat
                                'delivery_address' => $record->user->address ?? 'Alamat user tidak ditemukan', 
                            ]);
                        }
                    })

                    // --- PROSES SIMPAN KE DATABASE ---
                    ->action(function ($record, array $data) {
                        // Gunakan updateOrCreate agar tidak duplikat
                        // Cari delivery berdasarkan transaction_id, kalau gak ada buat baru.
                        $delivery = Delivery::updateOrCreate(
                            ['transaction_id' => $record->id], // Kunci pencarian
                            [
                                'courier_id' => $data['courier_id'],
                                'status' => $data['status'],
                                'delivery_address' => $data['delivery_address'],
                                'notes' => $data['notes'],
                                // Set shipped_at otomatis jika statusnya 'shipped'
                                'shipped_at' => $data['status'] === 'shipped' ? now() : null,
                            ]
                        );

                        // Opsional: Update status Transaksi utama jadi 'shipped' juga biar sinkron
                        if ($data['status'] === 'shipped') {
                            $record->update(['status' => 'shipped']);
                        }

                        Notification::make()->title('Data Pengiriman Disimpan')->success()->send();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}