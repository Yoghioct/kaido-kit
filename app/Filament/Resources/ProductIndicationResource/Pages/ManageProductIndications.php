<?php

namespace App\Filament\Resources\ProductIndicationResource\Pages;

use App\Filament\Resources\ProductIndicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProductIndications extends ManageRecords
{
    protected static string $resource = ProductIndicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
