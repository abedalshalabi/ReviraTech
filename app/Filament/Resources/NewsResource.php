<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Filament\Resources\NewsResource\RelationManagers;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Tabs;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Support\Collection;
use Filament\Notifications\Notification;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                            ->directory('news'),
                        Forms\Components\TextInput::make('source_url')
                            ->url(),
                        Forms\Components\TagsInput::make('tags'),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->default(now()),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                        Forms\Components\Toggle::make('is_featured'),
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
                                Forms\Components\TextInput::make('author.en')
                                    ->label('Author (English)')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('source.en')
                                    ->label('Source (English)')
                                    ->maxLength(255),
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
                                Forms\Components\TextInput::make('author.ar')
                                    ->label('Author (Arabic)')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('source.ar')
                                    ->label('Source (Arabic)')
                                    ->maxLength(255),
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
                Tables\Columns\ImageColumn::make('image')
                    ->circular(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('author')
                    ->searchable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),
                Tables\Columns\TextColumn::make('views_count')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All news')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured Status')
                    ->placeholder('All news')
                    ->trueLabel('Featured only')
                    ->falseLabel('Not featured'),
                Tables\Filters\Filter::make('published_date')
                    ->form([
                        Forms\Components\DatePicker::make('published_from')
                            ->label('Published From'),
                        Forms\Components\DatePicker::make('published_until')
                            ->label('Published Until'),
                    ])
                    ->query(function (EloquentBuilder $query, array $data): EloquentBuilder {
                        return $query
                            ->when(
                                $data['published_from'],
                                fn (EloquentBuilder $query, $date): EloquentBuilder => $query->whereDate('published_at', '>=', $date),
                            )
                            ->when(
                                $data['published_until'],
                                fn (EloquentBuilder $query, $date): EloquentBuilder => $query->whereDate('published_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['published_from'] ?? null) {
                            $indicators[] = Indicator::make('Published from ' . \Carbon\Carbon::parse($data['published_from'])->toFormattedDateString())
                                ->removeField('published_from');
                        }
                        if ($data['published_until'] ?? null) {
                            $indicators[] = Indicator::make('Published until ' . \Carbon\Carbon::parse($data['published_until'])->toFormattedDateString())
                                ->removeField('published_until');
                        }
                        return $indicators;
                    }),
                Tables\Filters\Filter::make('views_range')
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('views_from')
                                    ->label('Views From')
                                    ->numeric(),
                                Forms\Components\TextInput::make('views_to')
                                    ->label('Views To')
                                    ->numeric(),
                            ])
                    ])
                    ->query(function (EloquentBuilder $query, array $data): EloquentBuilder {
                        return $query
                            ->when(
                                $data['views_from'],
                                fn (EloquentBuilder $query, $views): EloquentBuilder => $query->where('views_count', '>=', $views),
                            )
                            ->when(
                                $data['views_to'],
                                fn (EloquentBuilder $query, $views): EloquentBuilder => $query->where('views_count', '<=', $views),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['views_from'] ?? null) {
                            $indicators[] = Indicator::make('Views from ' . $data['views_from'])
                                ->removeField('views_from');
                        }
                        if ($data['views_to'] ?? null) {
                            $indicators[] = Indicator::make('Views to ' . $data['views_to'])
                                ->removeField('views_to');
                        }
                        return $indicators;
                    }),
                Tables\Filters\Filter::make('has_tags')
                    ->label('Has Tags')
                    ->toggle()
                    ->query(fn (EloquentBuilder $query): EloquentBuilder => $query->whereNotNull('tags')->where('tags', '!=', '[]')),
                Tables\Filters\Filter::make('has_source')
                    ->label('Has Source URL')
                    ->toggle()
                    ->query(fn (EloquentBuilder $query): EloquentBuilder => $query->whereNotNull('source_url')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function (Collection $records) {
                            $records->each(fn (News $record) => $record->update(['is_active' => true]));
                            Notification::make()
                                ->title('News articles activated successfully')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function (Collection $records) {
                            $records->each(fn (News $record) => $record->update(['is_active' => false]));
                            Notification::make()
                                ->title('News articles deactivated successfully')
                                ->warning()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('feature')
                        ->label('Mark as Featured')
                        ->icon('heroicon-o-star')
                        ->color('warning')
                        ->action(function (Collection $records) {
                            $records->each(fn (News $record) => $record->update(['is_featured' => true]));
                            Notification::make()
                                ->title('News articles marked as featured')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('unfeature')
                        ->label('Remove from Featured')
                        ->icon('heroicon-o-star')
                        ->color('gray')
                        ->action(function (Collection $records) {
                            $records->each(fn (News $record) => $record->update(['is_featured' => false]));
                            Notification::make()
                                ->title('News articles removed from featured')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('publish_now')
                        ->label('Publish Now')
                        ->icon('heroicon-o-calendar')
                        ->color('info')
                        ->action(function (Collection $records) {
                            $records->each(fn (News $record) => $record->update([
                                'published_at' => now(),
                                'is_active' => true
                            ]));
                            Notification::make()
                                ->title('News articles published successfully')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('schedule_publish')
                        ->label('Schedule Publish')
                        ->icon('heroicon-o-clock')
                        ->color('primary')
                        ->form([
                            Forms\Components\DateTimePicker::make('published_at')
                                ->label('Publish Date & Time')
                                ->required()
                                ->minDate(now()),
                        ])
                        ->action(function (Collection $records, array $data) {
                            $records->each(fn (News $record) => $record->update([
                                'published_at' => $data['published_at'],
                                'is_active' => true
                            ]));
                            Notification::make()
                                ->title('News articles scheduled for publishing')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('export')
                        ->label('Export Selected')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('primary')
                        ->action(function (Collection $records) {
                            // Export functionality can be implemented here
                            Notification::make()
                                ->title('Export functionality will be implemented')
                                ->info()
                                ->send();
                        }),
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
