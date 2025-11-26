<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use League\Flysystem\Visibility;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', titleAttribute: 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
                Select::make('created_by')
                    ->label('Created By')
                    ->relationship('user', 'name') 
                    ->default(auth()->id())
                    ->disabled()
                    ->dehydrated(),
                TextInput::make('product_name')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp. '),
                TextInput::make('stock')
                    ->required()
                    ->numeric(),
                FileUpload::make('image')
                    ->label('Product Image')
                    ->image()
                    ->disk('public')
                    ->directory('product-images')
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
