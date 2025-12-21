<?php

namespace App\Filament\Resources\Transactions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
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
                    ->color(fn (string $state): string => match ($state) {
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
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}