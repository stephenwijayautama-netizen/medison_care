<?php

namespace App\Filament\Resources\Deliveries\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DeliveryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('transaction_id')
                    ->required()
                    ->numeric(),
                TextInput::make('courier_id')
                    ->required()
                    ->numeric(),
                Textarea::make('delivery_address')
                    ->required()
                    ->columnSpanFull(),
                Select::make('status')
                    ->options([
            'preparing' => 'Preparing',
            'shipped' => 'Shipped',
            'in_transit' => 'In transit',
            'delivered' => 'Delivered',
            'failed' => 'Failed',
        ])
                    ->required(),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
                DateTimePicker::make('shipped_at'),
                DateTimePicker::make('delivered_at'),
            ]);
    }
}
