<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use League\Flysystem\Visibility;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->default(null),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('Link')
                    ->label('Link URL')
                    ->placeholder('https://example.com')
                    ->url()
                    ->suffixIcon('heroicon-m-globe-alt')
                    ->maxLength(255)
                    ->default(null),
                FileUpload::make('image')
                    ->label('News Image')
                    ->image()
                    ->disk('public')
                    ->directory('News-images')
                    ->visibility('public')
                    ->maxSize(10240)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/gif'])
                    ->downloadable()
                    ->openable()
                    ->previewable()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                    ])
            ]);
    }
}
