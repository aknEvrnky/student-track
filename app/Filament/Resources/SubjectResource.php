<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubjectResource\Pages;
use App\Filament\Resources\SubjectResource\RelationManagers;
use App\Models\Subject;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class SubjectResource extends Resource
{
    protected static ?string $model = Subject::class;

    protected static ?string $navigationIcon = 'heroicon-o-variable';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Başlık')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('course_id')
                    ->label('Ders')
                    ->relationship('course', 'title')
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\CheckboxList::make('courseTypes')
                    ->label('Ders Türleri')
                    ->relationship(titleAttribute: 'title')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable(),
                Tables\Columns\TextColumn::make('course.title')
                    ->label('Ders')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('courseTypes')
                    ->formatStateUsing(fn(Subject $record) => $record->courseTypes->pluck('title')->join(', '))
                    ->label('Ders Türleri'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('course_id')
                    ->label('Ders')
                    ->relationship('course', 'title'),

                Tables\Filters\SelectFilter::make('courseTypes')
                    ->label('Ders Türleri')
                    ->multiple()
                    ->preload()
                    ->relationship('courseTypes', 'title'),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultGroup(
                Group::make('course.id')
                    ->label('Ders')
                ->getTitleFromRecordUsing(fn (Subject $record) => $record->course->title)
            )
            ->reorderable('sort_order');
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
            'index' => Pages\ListSubjects::route('/'),
            'create' => Pages\CreateSubject::route('/create'),
            'edit' => Pages\EditSubject::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Konu';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Konular';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Kurslar';
    }
}
