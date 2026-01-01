<?php

namespace App\Filament\Resources\ShippingRates\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\DeleteAction;


class ShippingRatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('rowIndex')
                    ->label('#')
                    ->rowIndex(),

                TextColumn::make('name')
                    ->label('Layanan')
                    ->searchable()
                    ->weight('bold')
                    ->sortable(),

                TextColumn::make('cost')
                    ->label('Biaya')
                    ->money('IDR', locale: 'id') // Format Rupiah
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Estimasi')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->description),

                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
