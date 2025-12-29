<?php

namespace App\Filament\Resources\Reseps\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use League\Flysystem\Visibility;

class ResepForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_resep')
                    ->default(null),
                TextInput::make('catatan_tambahan')
                    ->default(null),
                 FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('reseps')
                    ->visibility('public')
                            ]);
    }
}
