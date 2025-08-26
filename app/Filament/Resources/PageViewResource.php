<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageViewResource\Pages;
use App\Models\PageView;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PageViewResource extends Resource
{
    protected static ?string $model = PageView::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'Analytics';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Page Views';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Page View Information')
                    ->schema([
                        Forms\Components\TextInput::make('url')
                            ->required()
                            ->maxLength(255)
                            ->url(),
                        Forms\Components\TextInput::make('ip_address')
                            ->label('IP Address')
                            ->maxLength(45),
                        Forms\Components\TextInput::make('user_agent')
                            ->label('User Agent')
                            ->maxLength(500),
                        Forms\Components\TextInput::make('referer')
                            ->label('Referer')
                            ->maxLength(255)
                            ->url(),
                        Forms\Components\DateTimePicker::make('date')
                            ->required()
                            ->default(now()),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('url')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_agent')
                    ->label('User Agent')
                    ->limit(30)
                    ->tooltip(function (PageView $record): ?string {
                        return $record->user_agent;
                    }),
                Tables\Columns\TextColumn::make('referer')
                    ->label('Referer')
                    ->limit(30)
                    ->tooltip(function (PageView $record): ?string {
                        return $record->referer;
                    }),
                Tables\Columns\TextColumn::make('date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('today')
                    ->query(fn (Builder $query): Builder => $query->whereDate('date', today()))
                    ->label('Today'),
                Tables\Filters\Filter::make('this_week')
                    ->query(fn (Builder $query): Builder => $query->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]))
                    ->label('This Week'),
                Tables\Filters\Filter::make('this_month')
                    ->query(fn (Builder $query): Builder => $query->whereMonth('date', now()->month))
                    ->label('This Month'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('date', 'desc');
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
            'index' => Pages\ListPageViews::route('/'),
            'create' => Pages\CreatePageView::route('/create'),
            'view' => Pages\ViewPageView::route('/{record}'),
            'edit' => Pages\EditPageView::route('/{record}/edit'),
        ];
    }

    // Removed navigation badge to improve performance
    // Badge was calling count() query on every page load
    // public static function getNavigationBadge(): ?string
    // {
    //     return static::getModel()::whereDate('date', today())->count();
    // }

    public static function canCreate(): bool
    {
        return false; // Page views are typically created automatically
    }
}