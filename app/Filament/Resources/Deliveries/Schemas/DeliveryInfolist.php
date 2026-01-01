<?php

namespace App\Filament\Resources\Deliveries\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DeliveryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('transaction_id')
                    ->numeric(),
                TextEntry::make('courier_id')
                    ->numeric(),
                TextEntry::make('tracking_number'),
                TextEntry::make('delivery_address')
                    ->columnSpanFull(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('shipped_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('delivered_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
