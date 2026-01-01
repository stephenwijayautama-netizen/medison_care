<?php

namespace App\Filament\Resources\ShippingRates\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;


class ShippingRateInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nama Layanan')
                    ->weight('bold'),

                TextEntry::make('cost')
                    ->label('Biaya Ongkir')
                    ->money('IDR', locale: 'id'),

                TextEntry::make('description')
                    ->label('Keterangan & Estimasi')
                    ->columnSpanFull(),

            ]);
    }
}
