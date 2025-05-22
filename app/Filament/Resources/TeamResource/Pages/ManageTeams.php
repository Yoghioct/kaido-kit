<?php

namespace App\Filament\Resources\TeamResource\Pages;

use App\Filament\Resources\TeamResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;

class ManageTeams extends ManageRecords
{
    protected static string $resource = TeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function handleRecordCreation(array $data): Model
    {
        $productGroups = $data['product_groups'] ?? [];
        unset($data['product_groups']);

        $team = static::getModel()::create($data);
        $team->productGroups()->sync($productGroups);

        return $team;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $productGroups = $data['product_groups'] ?? [];
        unset($data['product_groups']);

        $record->update($data);
        $record->productGroups()->sync($productGroups);

        return $record;
    }
}
