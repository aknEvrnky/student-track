<?php

namespace App\Filament\Resources\SolvedQuestionRecordResource\Pages;

use App\Filament\Resources\SolvedQuestionRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSolvedQuestionRecords extends ManageRecords
{
    protected static string $resource = SolvedQuestionRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->mutateFormDataUsing(function ($data) {
                if (auth()->hasUser() && auth()->user()->isAdmin()) {
                    return $data;
                }

                return array_merge($data, [
                    'student_id' => auth()->id(),
                ]);
            }),
        ];
    }
}
