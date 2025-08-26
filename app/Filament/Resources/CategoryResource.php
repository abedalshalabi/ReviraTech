<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Tabs;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('parent');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Common Information')
                    ->schema([
                        Forms\Components\TextInput::make('slug')
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->directory('categories'),
                        Forms\Components\Select::make('parent_id')
                            ->relationship('parent', 'name')
                            ->searchable(),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                        Forms\Components\Toggle::make('is_featured')
                            ->default(false),
                    ]),
                Tabs::make('Translations')
                    ->tabs([
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('name.en')
                                    ->label('Name (English)')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description.en')
                                    ->label('Description (English)')
                                    ->rows(3),
                                Forms\Components\TextInput::make('meta_title.en')
                                    ->label('Meta Title (English)')
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('meta_description.en')
                                    ->label('Meta Description (English)')
                                    ->rows(2),
                                Forms\Components\TagsInput::make('meta_keywords.en')
                                    ->label('Meta Keywords (English)'),
                            ]),
                        Tabs\Tab::make('Arabic')
                            ->schema([
                                Forms\Components\TextInput::make('name.ar')
                                    ->label('Name (Arabic)')
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description.ar')
                                    ->label('Description (Arabic)')
                                    ->rows(3),
                                Forms\Components\TextInput::make('meta_title.ar')
                                    ->label('Meta Title (Arabic)')
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('meta_description.ar')
                                    ->label('Meta Description (Arabic)')
                                    ->rows(2),
                                Forms\Components\TagsInput::make('meta_keywords.ar')
                                    ->label('Meta Keywords (Arabic)'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Parent Category')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image')
                    ->circular(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
                Tables\Filters\TernaryFilter::make('is_featured'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
