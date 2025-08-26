<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderResource\Pages;
use App\Filament\Resources\SliderResource\RelationManagers;
use App\Models\Slider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Tabs;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Common Information')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->directory('sliders')
                            ->required()
                            ->helperText('Main slider image'),
                        Forms\Components\TextInput::make('button_url')
                            ->url()
                            ->maxLength(255)
                            ->helperText('URL for the call-to-action button'),
                        Forms\Components\TextInput::make('video_url')
                            ->url()
                            ->maxLength(255)
                            ->helperText('Optional video URL (YouTube, Vimeo, etc.)'),
                        Forms\Components\DateTimePicker::make('start_date')
                            ->helperText('When this slider should start showing (optional)'),
                        Forms\Components\DateTimePicker::make('end_date')
                            ->helperText('When this slider should stop showing (optional)'),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true)
                            ->helperText('Enable/disable this slider'),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Order in which sliders appear'),
                    ]),
                Tabs::make('Translations')
                    ->tabs([
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('title.en')
                                    ->label('Title (English)')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description.en')
                                    ->label('Description (English)')
                                    ->rows(3),
                                Forms\Components\TextInput::make('button_text.en')
                                    ->label('Button Text (English)')
                                    ->maxLength(255),
                            ]),
                        Tabs\Tab::make('Arabic')
                            ->schema([
                                Forms\Components\TextInput::make('title.ar')
                                    ->label('Title (Arabic)')
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description.ar')
                                    ->label('Description (Arabic)')
                                    ->rows(3),
                                Forms\Components\TextInput::make('button_text.ar')
                                    ->label('Button Text (Arabic)')
                                    ->maxLength(255),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->size(60),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('button_text')
                    ->badge()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
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
                Tables\Filters\Filter::make('current')
                    ->query(function ($query) {
                        return $query->current();
                    })
                    ->label('Current Sliders'),
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
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}
