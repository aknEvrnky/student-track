<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseTypeResource\Pages;
use App\Filament\Resources\CourseTypeResource\RelationManagers;
use App\Models\CourseType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseTypeResource extends Resource
{
    protected static ?string $model = CourseType::class;

    protected static ?string $navigationIcon = 'heroicon-o-funnel';

    protected static ?string $recordTitleAttribute = 'name';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Başlık')
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCourseTypes::route('/'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Kurs Tipi';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Kurs Tipleri';
    }
}
