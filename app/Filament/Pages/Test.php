<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Test extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Doctor Management';

    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.test';

    public function getTitle(): string
    {
        return 'Test Page';
    }
}
