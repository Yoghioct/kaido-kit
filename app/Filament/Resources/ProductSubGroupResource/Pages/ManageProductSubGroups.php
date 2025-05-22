<?php

namespace App\Filament\Resources\ProductSubGroupResource\Pages;

use App\Filament\Resources\ProductSubGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProductSubGroups extends ManageRecords
{
    protected static string $resource = ProductSubGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
