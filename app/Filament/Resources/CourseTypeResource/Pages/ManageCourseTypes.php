<?php

namespace App\Filament\Resources\CourseTypeResource\Pages;

use App\Filament\Resources\CourseTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCourseTypes extends ManageRecords
{
    protected static string $resource = CourseTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
