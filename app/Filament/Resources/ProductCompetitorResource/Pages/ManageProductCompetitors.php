<?php

namespace App\Filament\Resources\ProductCompetitorResource\Pages;

use App\Filament\Resources\ProductCompetitorResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProductCompetitors extends ManageRecords
{
    protected static string $resource = ProductCompetitorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
