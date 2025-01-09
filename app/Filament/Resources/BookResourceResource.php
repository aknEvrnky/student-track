<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResourceResource\Pages;
use App\Filament\Resources\BookResourceResource\RelationManagers;
use App\Models\BookResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookResourceResource extends Resource
{
    protected static ?string $model = BookResource::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Başlık')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('publisher_id')
                    ->label('Yayınevi')
                    ->relationship('publisher', 'title')
                    ->createOptionForm([
                        Forms\Components\TextInput::make('title')
                            ->label('Başlık')
                            ->required(),
                    ])
                    ->required(),
                Forms\Components\Select::make('course_id')
                    ->label('Ders')
                    ->relationship('course', 'title')
                    ->required(),
                Forms\Components\TextInput::make('published_year')
                    ->label('Yayın Yılı')
                    ->default(date('Y'))
                    ->maxLength(4)
                    ->numeric(),
                Forms\Components\TextInput::make('isbn')
                    ->label('ISBN')
                    ->maxLength(13),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable(),
                Tables\Columns\TextColumn::make('publisher.title')
                    ->label('Yayınevi')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('course.title')
                    ->label('Ders')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_year')
                    ->label('Yayın Yılı')
                    ->sortable(),
                Tables\Columns\TextColumn::make('isbn')
                    ->label('ISBN')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma Tarihi')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Güncellenme Tarihi')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBookResources::route('/'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Kitap Kaynağı';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Kitap Kaynakları';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Kaynaklar';
    }
}
