<?php

namespace App\Filament\Resources\ProductKeyMessageResource\Pages;

use App\Filament\Resources\ProductKeyMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProductKeyMessages extends ManageRecords
{
    protected static string $resource = ProductKeyMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
