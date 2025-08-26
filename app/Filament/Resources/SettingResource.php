<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Unique identifier for the setting'),
                Forms\Components\Textarea::make('value')
                    ->required()
                    ->rows(3)
                    ->helperText('The setting value'),
                Forms\Components\Select::make('type')
                    ->required()
                    ->options([
                        'text' => 'Text',
                        'textarea' => 'Textarea',
                        'number' => 'Number',
                        'boolean' => 'Boolean',
                        'email' => 'Email',
                        'url' => 'URL',
                        'json' => 'JSON',
                        'file' => 'File',
                        'image' => 'Image',
                    ])
                    ->default('text')
                    ->helperText('Type of the setting value'),
                Forms\Components\Select::make('group')
                    ->required()
                    ->options([
                        'general' => 'General',
                        'site' => 'Site',
                        'email' => 'Email',
                        'social' => 'Social Media',
                        'seo' => 'SEO',
                        'appearance' => 'Appearance',
                        'advanced' => 'Advanced',
                    ])
                    ->default('general')
                    ->helperText('Group to organize settings'),
                Forms\Components\Textarea::make('description')
                    ->rows(2)
                    ->helperText('Description of what this setting does'),
                Forms\Components\Toggle::make('is_translatable')
                    ->helperText('Whether this setting can be translated'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('value')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'text' => 'gray',
                        'textarea' => 'blue',
                        'number' => 'green',
                        'boolean' => 'yellow',
                        'email' => 'purple',
                        'url' => 'indigo',
                        'json' => 'orange',
                        'file' => 'red',
                        'image' => 'pink',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('group')
                    ->badge()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_translatable')
                    ->boolean()
                    ->label('Translatable'),
                Tables\Columns\TextColumn::make('description')
                    ->limit(30)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(false),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'text' => 'Text',
                        'textarea' => 'Textarea',
                        'number' => 'Number',
                        'boolean' => 'Boolean',
                        'email' => 'Email',
                        'url' => 'URL',
                        'json' => 'JSON',
                        'file' => 'File',
                        'image' => 'Image',
                    ]),
                Tables\Filters\SelectFilter::make('group')
                    ->options([
                        'general' => 'General',
                        'site' => 'Site',
                        'email' => 'Email',
                        'social' => 'Social Media',
                        'seo' => 'SEO',
                        'appearance' => 'Appearance',
                        'advanced' => 'Advanced',
                    ]),
                Tables\Filters\TernaryFilter::make('is_translatable'),
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
            ->defaultSort('group');
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
