<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SolvedQuestionRecordResource\Pages;
use App\Filament\Resources\SolvedQuestionRecordResource\RelationManagers;
use App\Models\SolvedQuestionRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Sum;
use Illuminate\Support\Facades\DB;

class SolvedQuestionRecordResource extends Resource
{
    protected static ?string $model = SolvedQuestionRecord::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('number_of_solved_questions')
                    ->label('Çözülen Soru Sayısı')
                    ->required()
                    ->suffix('adet')
                    ->numeric(),
                Forms\Components\Select::make('student_id')
                    ->label('Öğrenci')
                    ->visible(fn() => auth()->user()?->isAdmin())
                    ->relationship('student', 'name')
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('course_id')
                    ->live()
                    ->label('Ders')
                    ->relationship('course', 'title')
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('book_resource_id')
                    ->live()
                    ->searchable()
                    ->relationship('bookResource', 'title', function (Builder $builder, Forms\Get $get) {
                        if ($get('course_id')) {
                            $builder->where('course_id', $get('course_id'));
                        }
                    }
                    )
                    ->label('Kitap')
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('subject_id')
                    ->live()
                    ->relationship('subject', 'title', function (Builder $builder, Forms\Get $get) {
                        if ($get('course_id')) {
                            $builder->where('course_id', $get('course_id'));
                        }
                    }
                    )
                    ->searchable()
                    ->label('Konu')
                    ->preload(),
                Forms\Components\DatePicker::make('solved_at')
                    ->label('Çözülme Tarihi')
                    ->default(now())
                    ->maxDate(now())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('solved_at')
                    ->label('Çözülme Tarihi')
                    ->date(),
                Tables\Columns\TextColumn::make('number_of_solved_questions')
                    ->label('Çözülen Soru Sayısı')
                    ->numeric()
                    ->summarize([
                        Average::make(),
                        Sum::make(),
                    ]),
                Tables\Columns\TextColumn::make('student.name')
                    ->label('Öğrenci')
                    ->visible(fn() => auth()->user()?->isAdmin()),
                Tables\Columns\TextColumn::make('course.title')
                    ->label('Ders')
                    ->numeric(),
                Tables\Columns\TextColumn::make('bookResource.title')
                    ->label('Kitap')
                    ->numeric(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma Tarihi')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Güncellenme Tarihi')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('student_id')
                    ->label('Öğrenci')
                    ->preload()
                    ->multiple()
                    ->relationship('student', 'name')
                    ->visible(fn() => auth()->user()?->isAdmin()),
                Tables\Filters\SelectFilter::make('course_id')
                    ->label('Ders')
                    ->multiple()
                    ->preload()
                    ->relationship('course', 'title'),
                Tables\Filters\SelectFilter::make('book_resource_id')
                    ->label('Kitap')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->relationship('bookResource', 'title'),
                QueryBuilder::make('dateFilters')
                    ->constraints([
                        DateConstraint::make('solved_at')
                            ->label('Çözülme Tarihi'),
                        DateConstraint::make('solved_at')
                            ->label('Çözülme Tarihi'),
                    ])
            ])
            ->filtersFormWidth(MaxWidth::ExtraLarge)
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->query(static::getEloquentQuery())
            ->modifyQueryUsing(fn(Builder $query) => $query->select([
                '*',
                DB::raw('WEEK(solved_at, 1) AS week'),
                DB::raw('MONTH(solved_at) AS month'),
            ]))
            ->defaultSort('solved_at', 'desc')
            ->groups([
                Tables\Grouping\Group::make('week')
                    ->label('Hafta')
                    ->titlePrefixedWithLabel(false)
                    ->getTitleFromRecordUsing(fn ($record) => $record->solved_at->translatedFormat('Y M') . ' Hafta: ' . $record->week),
                Tables\Grouping\Group::make('month')
                    ->label('Ay')
                    ->titlePrefixedWithLabel(false)
                    ->getTitleFromRecordUsing(fn ($record) => $record->solved_at->translatedFormat('Y M')),
            ])
            ->paginationPageOptions([25, 50, 100, 'all'])
            ->defaultPaginationPageOption(25);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSolvedQuestionRecords::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->when(
            ! auth()->user()?->isAdmin(),
            fn (Builder $query) => $query->where('student_id', auth()->id()),
        );
    }

    public static function getModelLabel(): string
    {
        return 'Çözülen Soru Kaydı';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Çözülen Soru Kayıtları';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Kaynaklar';
    }

}
