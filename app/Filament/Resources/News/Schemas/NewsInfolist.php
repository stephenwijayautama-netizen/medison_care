<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Factories\Relationship;
use Filament\Infolists\Components\ImageEntry;

class NewsInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title')
                    ->label('Category'),
                TextEntry::make('description')
                    ->columnSpanFull(),
                ImageEntry::make('image')
                    ->label('Image Product')
                    ->disk('public')
                    ->placeholder('-'),
            ]);
    }
}
