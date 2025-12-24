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
                FileUpload::make('image')
                    ->label('Resep Image')
                    ->image()
                    ->disk('public')
                    ->directory('Resep-images')
                    ->Visibility(Visibility::PUBLIC)
                    ->maxSize(4096)
                    ->confirmSvgEditing()
                    ->downloadable()
                    ->openable()
                    ->previewable()
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                    ])
            ]);
    }
}
