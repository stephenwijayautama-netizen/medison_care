<?php

namespace App\Filament\Resources\Reseps\Pages;

use App\Filament\Resources\Reseps\ResepResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewResep extends ViewRecord
{
    protected static string $resource = ResepResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
