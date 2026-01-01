<?php

namespace App\Filament\Resources\Couriers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CourierForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('phone')
                ->label('Nomor Telepon')
                ->tel() // Format input telepon
                ->required() // Wajib diisi agar tidak error database lagi
                ->maxLength(20),
                TextInput::make('address')
                    ->required(),
            ]);
    }
}
