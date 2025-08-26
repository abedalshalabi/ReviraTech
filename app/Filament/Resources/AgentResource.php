<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgentResource\Pages;
use App\Filament\Resources\AgentResource\RelationManagers;
use App\Models\Agent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Tabs;

class AgentResource extends Resource
{
    protected static ?string $model = Agent::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Common Information')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('website')
                            ->url()
                            ->maxLength(255),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ]),
                Tabs::make('Translations')
                    ->tabs([
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('name.en')
                                    ->label('Name (English)')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('company_name.en')
                                    ->label('Company Name (English)')
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description.en')
                                    ->label('Description (English)')
                                    ->rows(3),
                                Forms\Components\Textarea::make('address.en')
                                    ->label('Address (English)')
                                    ->rows(2),
                                Forms\Components\TextInput::make('city.en')
                                    ->label('City (English)')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('country.en')
                                    ->label('Country (English)')
                                    ->maxLength(255),
                            ]),
                        Tabs\Tab::make('Arabic')
                            ->schema([
                                Forms\Components\TextInput::make('name.ar')
                                    ->label('Name (Arabic)')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('company_name.ar')
                                    ->label('Company Name (Arabic)')
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description.ar')
                                    ->label('Description (Arabic)')
                                    ->rows(3),
                                Forms\Components\Textarea::make('address.ar')
                                    ->label('Address (Arabic)')
                                    ->rows(2),
                                Forms\Components\TextInput::make('city.ar')
                                    ->label('City (Arabic)')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('country.ar')
                                    ->label('Country (Arabic)')
                                    ->maxLength(255),
                            ]),
                    ]),
                Forms\Components\FileUpload::make('logo')
                    ->image()
                    ->directory('agents/logos'),
                Forms\Components\TextInput::make('latitude')
                    ->numeric()
                    ->step(0.00000001),
                Forms\Components\TextInput::make('longitude')
                    ->numeric()
                    ->step(0.00000001),
                Forms\Components\Textarea::make('working_hours')
                    ->helperText('Enter working hours as JSON format')
                    ->rows(3),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('company_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(false),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
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
            'index' => Pages\ListAgents::route('/'),
            'create' => Pages\CreateAgent::route('/create'),
            'edit' => Pages\EditAgent::route('/{record}/edit'),
        ];
    }
}
