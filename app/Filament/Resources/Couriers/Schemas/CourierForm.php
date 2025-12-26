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
                    ->required(),
                TextInput::make('address')
                    ->required(),
            ]);
    }
}
