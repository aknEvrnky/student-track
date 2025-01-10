<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Actions\ChangePasswordAction;
use App\Filament\Resources\StudentResource;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;

class EditStudent extends EditRecord
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            ChangePasswordAction::make(),
        ];
    }
}
