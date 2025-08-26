<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Tabs;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Common Information')
                    ->schema([
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->directory('pages'),
                        Forms\Components\Select::make('template')
                            ->options([
                                'default' => 'Default',
                                'about' => 'About',
                                'contact' => 'Contact',
                                'services' => 'Services',
                            ])
                            ->default('default'),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                        Forms\Components\Toggle::make('is_homepage')
                            ->default(false),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                    ]),
                Tabs::make('Translations')
                    ->tabs([
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('title.en')
                                    ->label('Title (English)')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('summary.en')
                                    ->label('Summary (English)')
                                    ->rows(3),
                                Forms\Components\RichEditor::make('content.en')
                                    ->label('Content (English)')
                                    ->columnSpanFull(),
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
                                Forms\Components\TextInput::make('title.ar')
                                    ->label('Title (Arabic)')
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('summary.ar')
                                    ->label('Summary (Arabic)')
                                    ->rows(3),
                                Forms\Components\RichEditor::make('content.ar')
                                    ->label('Content (Arabic)')
                                    ->columnSpanFull(),
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
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('pages'),
                Forms\Components\Select::make('template')
                    ->options([
                        'default' => 'Default',
                        'about' => 'About',
                        'contact' => 'Contact',
                        'services' => 'Services',
                    ])
                    ->default('default'),
                Forms\Components\KeyValue::make('meta_data')
                    ->label('Additional Meta Data'),
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
                Forms\Components\Toggle::make('is_homepage')
                    ->default(false),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->circular(),
                Tables\Columns\TextColumn::make('template')
                    ->badge(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_homepage')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(false),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
                Tables\Filters\TernaryFilter::make('is_homepage'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order');
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
