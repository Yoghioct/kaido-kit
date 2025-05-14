<?php

namespace App\Filament\Resources\SpecialistResource\Pages;

use App\Filament\Resources\SpecialistResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSpecialist extends EditRecord
{
    protected static string $resource = SpecialistResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
