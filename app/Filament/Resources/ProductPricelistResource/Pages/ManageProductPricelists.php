<?php

namespace App\Filament\Resources\ProductPricelistResource\Pages;

use App\Filament\Resources\ProductPricelistResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProductPricelists extends ManageRecords
{
    protected static string $resource = ProductPricelistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
