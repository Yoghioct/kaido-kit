<?php

namespace App\Filament\Resources\SpecialistResource\Pages;

use App\Filament\Resources\SpecialistResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ManageSpecialists extends ListRecords
{
    protected static string $resource = SpecialistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalHeading('Create Specialist'),
                // ->slideOver(),
        ];
    }
}
