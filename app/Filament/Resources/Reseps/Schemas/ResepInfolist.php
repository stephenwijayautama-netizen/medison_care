<?php

namespace App\Filament\Resources\Reseps\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class ResepInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nama_resep')
                    ->label('Nama Resep'),
                ImageEntry::make('image')
                    ->label('Image Product')
                    ->disk('public')
                    ->placeholder('-'),
            ]);
    }                   
}
