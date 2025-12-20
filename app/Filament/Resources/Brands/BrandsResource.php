<?php

namespace App\Filament\Resources\Brands;

use App\Filament\Resources\Brands\Pages\CreateBrands;
use App\Filament\Resources\Brands\Pages\EditBrands;
use App\Filament\Resources\Brands\Pages\ListBrands;
use App\Filament\Resources\Brands\Pages\ViewBrands;
use App\Filament\Resources\Brands\Schemas\BrandsInfolist;
use App\Filament\Resources\Brands\Schemas\BrandsForm;
use App\Filament\Resources\Brands\Tables\BrandsTable;
use App\Models\Brands;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BrandsResource extends Resource
{
    protected static ?string $model = Brands::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Brands';

    public static function form(Schema $schema): Schema
    {
        return BrandsForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BrandsInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BrandsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBrands::route('/'),
            'create' => CreateBrands::route('/create'),
            'view' => ViewBrands::route('/{record}'),
            'edit' => EditBrands::route('/{record}/edit'),
        ];
    }
}
