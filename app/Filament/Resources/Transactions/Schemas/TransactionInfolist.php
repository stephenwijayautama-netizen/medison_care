<?php

namespace App\Filament\Resources\Transactions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Group;
use Filament\Schemas\Schema;

class TransactionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // --- INFORMASI TRANSAKSI ---
                Section::make('Informasi Transaksi')
                    ->schema([
                        Group::make([
                            TextEntry::make('user.name')
                                ->label('Customer'),
                            TextEntry::make('invoice_number')
                                ->label('Invoice Number')
                                ->placeholder('-'),
                        ])->columns(2),

                        Group::make([
                            TextEntry::make('total_amount')
                                ->label('Total Belanja')
                                ->numeric()
                                ->prefix('Rp '),
                            TextEntry::make('shipping_cost')
                                ->label('Ongkos Kirim')
                                ->numeric()
                                ->prefix('Rp '),
                        ])->columns(2),

                        Group::make([
                            TextEntry::make('status')
                                ->badge()
                                ->color(fn(string $state): string => match ($state) {
                                    'pending', 'processing' => 'warning',
                                    'paid', 'shipped', 'delivered' => 'success',
                                    'cancelled' => 'danger',
                                    default => 'gray',
                                }),
                            TextEntry::make('payment_method')
                                ->label('Metode Pembayaran')
                                ->badge()
                                ->color('info'),
                        ])->columns(2),

                        TextEntry::make('transaction_date')
                            ->label('Tanggal Transaksi')
                            ->dateTime('d M Y H:i'),
                    ])->columns(1),

                // --- INFORMASI PENGIRIMAN ---
                Section::make('Informasi Pengiriman')
                    ->schema([
                        TextEntry::make('delivery.courier.name')
                            ->label('Kurir')
                            ->placeholder('Belum dipilih'),
                        
                        TextEntry::make('delivery.status')
                            ->label('Status Pengiriman')
                            ->badge()
                            ->color(fn(?string $state): string => match ($state) {
                                'preparing' => 'warning',
                                'shipped' => 'info',
                                'delivered' => 'success',
                                default => 'gray',
                            })
                            ->placeholder('Belum ada pengiriman'),

                        TextEntry::make('delivery.delivery_address')
                            ->label('Alamat Pengiriman')
                            ->columnSpanFull()
                            ->placeholder('-'),

                        Group::make([
                            TextEntry::make('delivery.shipped_at')
                                ->label('Tanggal Dikirim')
                                ->dateTime('d M Y H:i')
                                ->placeholder('Belum dikirim'),
                            
                            TextEntry::make('delivery.delivered_at')
                                ->label('Tanggal Diterima')
                                ->dateTime('d M Y H:i')
                                ->placeholder('Belum diterima'),
                        ])->columns(2),

                        TextEntry::make('delivery.notes')
                            ->label('Catatan')
                            ->columnSpanFull()
                            ->placeholder('-'),
                    ])
                    ->visible(fn($record) => $record->delivery !== null)
                    ->columns(2),

                // --- DETAIL WAKTU ---
                Section::make('Detail Waktu')
                    ->schema([
                        Group::make([
                            TextEntry::make('created_at')
                                ->label('Dibuat pada')
                                ->dateTime('d M Y H:i')
                                ->placeholder('-'),
                            
                            TextEntry::make('updated_at')
                                ->label('Diupdate pada')
                                ->dateTime('d M Y H:i')
                                ->placeholder('-'),
                        ])->columns(2),
                    ])
                    ->collapsed()
                    ->columns(1),
            ]);
    }
}

