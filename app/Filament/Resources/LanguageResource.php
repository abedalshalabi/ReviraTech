<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LanguageResource\Pages;
use App\Filament\Resources\LanguageResource\RelationManagers;
use App\Models\Language;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LanguageResource extends Resource
{
    protected static ?string $model = Language::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(10)
                    ->helperText('Language code (e.g., en, fr, de)'),
                Forms\Components\TextInput::make('locale')
                    ->required()
                    ->maxLength(10)
                    ->helperText('Locale code (e.g., en_US, fr_FR)'),
                Forms\Components\FileUpload::make('flag')
                    ->image()
                    ->directory('languages/flags')
                    ->helperText('Flag image for the language'),
                Forms\Components\Toggle::make('is_rtl')
                    ->label('Right to Left')
                    ->helperText('Check if this language is written from right to left'),
                Forms\Components\Toggle::make('is_active')
                    ->default(true)
                    ->helperText('Enable/disable this language'),
                Forms\Components\Toggle::make('is_default')
                    ->helperText('Set as default language'),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->helperText('Order in which languages appear'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('flag')
                    ->circular()
                    ->size(30),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable()
                    ->badge(),
                Tables\Columns\TextColumn::make('locale')
                    ->searchable()
                    ->badge(),
                Tables\Columns\IconColumn::make('is_rtl')
                    ->boolean()
                    ->label('RTL'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                Tables\Columns\IconColumn::make('is_default')
                    ->boolean()
                    ->label('Default'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(false),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
                Tables\Filters\TernaryFilter::make('is_default'),
                Tables\Filters\TernaryFilter::make('is_rtl'),
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
            'index' => Pages\ListLanguages::route('/'),
            'create' => Pages\CreateLanguage::route('/create'),
            'edit' => Pages\EditLanguage::route('/{record}/edit'),
        ];
    }
}
