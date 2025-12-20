<?php

namespace App\Filament\Resources\Brands\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Factories\Relationship;
use Filament\Infolists\Components\ImageEntry;

class BrandsInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Name Brand'),
                TextEntry::make('description')
                    ->columnSpanFull(),
                ImageEntry::make('image')
                    ->label('Image Brand')
                    ->disk('public')
                    ->placeholder('-'),
            ]);
    }
}
