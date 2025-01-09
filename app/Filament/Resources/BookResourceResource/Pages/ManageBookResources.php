<?php

namespace App\Filament\Resources\BookResourceResource\Pages;

use App\Filament\Resources\BookResourceResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBookResources extends ManageRecords
{
    protected static string $resource = BookResourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
