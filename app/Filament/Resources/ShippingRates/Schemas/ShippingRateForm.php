<?php

namespace App\Filament\Resources\ShippingRates\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;   
use Filament\Forms\Components\Select;      


class ShippingRateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                        TextInput::make('name')
                            ->label('Nama Layanan / Jarak')
                            ->placeholder('Contoh: JNE Reguler atau 0-5 KM')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('cost')
                            ->label('Biaya Ongkir')
                            ->prefix('Rp')
                            ->numeric() // Agar input hanya angka
                            ->required()
                            ->placeholder('Contoh: 20000'),

                        Textarea::make('description')
                            ->label('Keterangan / Estimasi')
                            ->placeholder('Contoh: Estimasi 2-3 Hari Sampai')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]);
    }
}
