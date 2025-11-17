<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\ImageEntry;
class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('role.position')
                    ->label('Role')
                    ->badge()
                    ->colors([
                        'danger' => 'Owner',
                        'warning' => 'Admin',
                        'success' => 'Customer',
                    ]),
                TextEntry::make('name'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('email_verified_at')
                    ->dateTime()
                    ->placeholder('-'),
                ImageEntry::make('image')
                    ->label('Foto Profil')
                    ->disk('public')
                    ->placeholder('-'),
                TextEntry::make('address')
                    ->columnSpanFull(),
                TextEntry::make('phone'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
