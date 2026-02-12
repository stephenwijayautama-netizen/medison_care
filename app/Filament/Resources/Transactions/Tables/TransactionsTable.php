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
                        Select::make('courier_id')
                            ->label('Pilih Kurir')
                            ->options(Courier::all()->pluck('name', 'id'))
                            ->required(),

                        // 2. Status Pengiriman
                        Select::make('status')
                            ->label('Status Pengiriman')
                            ->options([
                                'preparing' => 'Sedang Dipersiapkan',
                                'shipped' => 'Dikirim (Shipped)',
                                'delivered' => 'Sampai Tujuan',
                            ])
                            ->default('preparing')
                            ->required()
                            ->reactive(),

                        Textarea::make('delivery_address')
                            ->label('Alamat Pengiriman')
                            ->rows(3)
                            ->required()
                            ->columnSpanFull(),
                        
                        Textarea::make('notes')
                            ->label('Catatan Tambahan (Opsional)')
                            ->rows(2),
                    ])

                    // --- ISI DATA SAAT MODAL DIBUKA ---
                    ->mountUsing(function ($form, $record) {
                        // SKENARIO 1: Data pengiriman SUDAH ADA di database
                        if ($record->delivery) {
                            $form->fill([
                                'courier_id' => $record->delivery->courier_id,
                                'status' => $record->delivery->status,
                                'delivery_address' => $record->delivery->delivery_address,
                                'notes' => $record->delivery->notes,
                            ]);
                        } 
                        // SKENARIO 2: Data pengiriman BELUM ADA (Baru mau input)
                        else {
                            $form->fill([
                                'status' => 'preparing',
                                'delivery_address' => $record->user->address ?? 'Alamat user tidak ditemukan', 
                            ]);
                        }
                    })

                    // --- PROSES SIMPAN KE DATABASE ---
                    ->action(function ($record, array $data) {
                        // Ambil delivery yang sudah ada (untuk cek timestamp lama)
                        $existingDelivery = Delivery::where('transaction_id', $record->id)->first();
                        
                        // Tentukan timestamp berdasarkan status
                        $shippedAt = null;
                        $deliveredAt = null;
                        
                        if ($data['status'] === 'shipped') {
                            // Jika sudah pernah shipped sebelumnya, pertahankan timestamp lama
                            $shippedAt = $existingDelivery && $existingDelivery->shipped_at 
                                ? $existingDelivery->shipped_at 
                                : now();
                        } elseif ($data['status'] === 'delivered') {
                            // Pertahankan shipped_at, tambahkan delivered_at
                            $shippedAt = $existingDelivery && $existingDelivery->shipped_at 
                                ? $existingDelivery->shipped_at 
                                : now();
                            $deliveredAt = $existingDelivery && $existingDelivery->delivered_at 
                                ? $existingDelivery->delivered_at 
                                : now();
                        }

                        // Update atau buat delivery record
                        $delivery = Delivery::updateOrCreate(
                            ['transaction_id' => $record->id],
                            [
                                'courier_id' => $data['courier_id'],
                                'status' => $data['status'],
                                'delivery_address' => $data['delivery_address'],
                                'notes' => $data['notes'] ?? null,
                                'shipped_at' => $shippedAt,
                                'delivered_at' => $deliveredAt,
                            ]
                        );

                        // Update status Transaction sesuai dengan status delivery
                        $transactionStatus = match($data['status']) {
                            'preparing' => 'processing',  // Sedang diproses
                            'shipped' => 'shipped',       // Sudah dikirim
                            'delivered' => 'delivered',   // Sudah sampai
                            default => $record->status,   // Pertahankan status lama
                        };

                        $record->update(['status' => $transactionStatus]);

                        Notification::make()
                            ->title('Data Pengiriman Berhasil Disimpan')
                            ->body("Status transaksi diupdate menjadi: " . ucfirst($transactionStatus))
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}