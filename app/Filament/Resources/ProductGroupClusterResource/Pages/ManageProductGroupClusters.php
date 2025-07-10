<?php

namespace App\Filament\Resources\ProductGroupClusterResource\Pages;

use App\Filament\Resources\ProductGroupClusterResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProductGroupClusters extends ManageRecords
{
    protected static string $resource = ProductGroupClusterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalHeading('Create Product Group Cluster')
                ->modalDescription('Create a new product group cluster to group related products together.')
                ->modalSubmitActionLabel('Create Cluster'),
        ];
    }
}
