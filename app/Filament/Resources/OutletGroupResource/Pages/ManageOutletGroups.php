<?php

namespace App\Filament\Resources\OutletGroupResource\Pages;

use App\Filament\Resources\OutletGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageOutletGroups extends ManageRecords
{
    protected static string $resource = OutletGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
