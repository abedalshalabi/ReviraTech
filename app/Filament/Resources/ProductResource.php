<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Support\Collection;
use Filament\Notifications\Notification;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('category');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Product Information')
                    ->tabs([
                        Tabs\Tab::make('Common Information')
                            ->schema([
                                Forms\Components\TextInput::make('slug')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('sku')
                                    ->label('SKU')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('model')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('brand')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('price')
                                    ->numeric()
                                    ->prefix('$'),
                                Forms\Components\TextInput::make('stock_quantity')
                                    ->numeric()
                                    ->default(0),
                                Forms\Components\Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->searchable(),
                                Forms\Components\Toggle::make('is_active')
                                    ->default(true),
                                Forms\Components\Toggle::make('is_featured')
                                    ->default(false),
                                SpatieMediaLibraryFileUpload::make('images')
                                    ->collection('images')
                                    ->multiple()
                                    ->reorderable()
                                    ->image()
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('16:9')
                                    ->imageResizeTargetWidth('1920')
                                    ->imageResizeTargetHeight('1080')
                                    ->maxFiles(10)
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])
                                    ->disk('public')
                                    ->directory('products')
                                    ->visibility('public')
                                    ->helperText('You can add multiple images. New images will be added to existing ones without removing them. You can also reorder them by dragging.'),
                            ]),
                        Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('name.en')
                                    ->label('Name (English)')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('short_description.en')
                                    ->label('Short Description (English)')
                                    ->rows(3),
                                Forms\Components\RichEditor::make('description.en')
                                    ->label('Description (English)')
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('technical_specifications.en')
                                    ->label('Technical Specifications (English)')
                                    ->rows(4),
                                Forms\Components\Textarea::make('features.en')
                                    ->label('Features (English)')
                                    ->rows(4),
                                Forms\Components\Textarea::make('applications.en')
                                    ->label('Applications (English)')
                                    ->rows(4),
                                Forms\Components\Textarea::make('warranty.en')
                                    ->label('Warranty (English)')
                                    ->rows(2),
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
                                Forms\Components\Textarea::make('short_description.ar')
                                    ->label('Short Description (Arabic)')
                                    ->rows(3),
                                Forms\Components\RichEditor::make('description.ar')
                                    ->label('Description (Arabic)')
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('technical_specifications.ar')
                                    ->label('Technical Specifications (Arabic)')
                                    ->rows(4),
                                Forms\Components\Textarea::make('features.ar')
                                    ->label('Features (Arabic)')
                                    ->rows(4),
                                Forms\Components\Textarea::make('applications.ar')
                                    ->label('Applications (Arabic)')
                                    ->rows(4),
                                Forms\Components\Textarea::make('warranty.ar')
                                    ->label('Warranty (Arabic)')
                                    ->rows(2),
                                Forms\Components\TextInput::make('meta_title.ar')
                                    ->label('Meta Title (Arabic)')
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('meta_description.ar')
                                    ->label('Meta Description (Arabic)')
                                    ->rows(2),
                                Forms\Components\TagsInput::make('meta_keywords.ar')
                                    ->label('Meta Keywords (Arabic)'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->circular()
                    ->size(50)
                    ->label('Image')
                    ->defaultImageUrl(url('/images/placeholder.png')),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('sku')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('brand')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_new')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All products')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured Status')
                    ->placeholder('All products')
                    ->trueLabel('Featured only')
                    ->falseLabel('Not featured'),
                Tables\Filters\TernaryFilter::make('is_new')
                    ->label('New Products')
                    ->placeholder('All products')
                    ->trueLabel('New only')
                    ->falseLabel('Not new'),
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),
                Tables\Filters\Filter::make('price_range')
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('price_from')
                                    ->label('Price From')
                                    ->numeric()
                                    ->prefix('$'),
                                Forms\Components\TextInput::make('price_to')
                                    ->label('Price To')
                                    ->numeric()
                                    ->prefix('$'),
                            ])
                    ])
                    ->query(function (EloquentBuilder $query, array $data): EloquentBuilder {
                        return $query
                            ->when(
                                $data['price_from'],
                                fn (EloquentBuilder $query, $price): EloquentBuilder => $query->where('price', '>=', $price),
                            )
                            ->when(
                                $data['price_to'],
                                fn (EloquentBuilder $query, $price): EloquentBuilder => $query->where('price', '<=', $price),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['price_from'] ?? null) {
                            $indicators[] = Indicator::make('Price from $' . $data['price_from'])
                                ->removeField('price_from');
                        }
                        if ($data['price_to'] ?? null) {
                            $indicators[] = Indicator::make('Price to $' . $data['price_to'])
                                ->removeField('price_to');
                        }
                        return $indicators;
                    }),
                Tables\Filters\Filter::make('stock_status')
                    ->form([
                        Forms\Components\Select::make('stock_status')
                            ->label('Stock Status')
                            ->options([
                                'in_stock' => 'In Stock',
                                'low_stock' => 'Low Stock (< 10)',
                                'out_of_stock' => 'Out of Stock',
                            ])
                    ])
                    ->query(function (EloquentBuilder $query, array $data): EloquentBuilder {
                        return $query->when(
                            $data['stock_status'],
                            function (EloquentBuilder $query, $status): EloquentBuilder {
                                return match ($status) {
                                    'in_stock' => $query->where('stock_quantity', '>', 0),
                                    'low_stock' => $query->where('stock_quantity', '>', 0)->where('stock_quantity', '<', 10),
                                    'out_of_stock' => $query->where('stock_quantity', '<=', 0),
                                    default => $query,
                                };
                            }
                        );
                    })
                    ->indicateUsing(function (array $data): ?Indicator {
                        if ($data['stock_status'] ?? null) {
                            return Indicator::make('Stock: ' . match($data['stock_status']) {
                                'in_stock' => 'In Stock',
                                'low_stock' => 'Low Stock',
                                'out_of_stock' => 'Out of Stock',
                                default => $data['stock_status'],
                            })->removeField('stock_status');
                        }
                        return null;
                    }),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Created From'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Created Until'),
                    ])
                    ->query(function (EloquentBuilder $query, array $data): EloquentBuilder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (EloquentBuilder $query, $date): EloquentBuilder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (EloquentBuilder $query, $date): EloquentBuilder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['created_from'] ?? null) {
                            $indicators[] = Indicator::make('Created from ' . \Carbon\Carbon::parse($data['created_from'])->toFormattedDateString())
                                ->removeField('created_from');
                        }
                        if ($data['created_until'] ?? null) {
                            $indicators[] = Indicator::make('Created until ' . \Carbon\Carbon::parse($data['created_until'])->toFormattedDateString())
                                ->removeField('created_until');
                        }
                        return $indicators;
                    }),
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
                            $records->each(fn (Product $record) => $record->update(['is_active' => true]));
                            Notification::make()
                                ->title('Products activated successfully')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function (Collection $records) {
                            $records->each(fn (Product $record) => $record->update(['is_active' => false]));
                            Notification::make()
                                ->title('Products deactivated successfully')
                                ->warning()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('feature')
                        ->label('Mark as Featured')
                        ->icon('heroicon-o-star')
                        ->color('warning')
                        ->action(function (Collection $records) {
                            $records->each(fn (Product $record) => $record->update(['is_featured' => true]));
                            Notification::make()
                                ->title('Products marked as featured')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('unfeature')
                        ->label('Remove from Featured')
                        ->icon('heroicon-o-star')
                        ->color('gray')
                        ->action(function (Collection $records) {
                            $records->each(fn (Product $record) => $record->update(['is_featured' => false]));
                            Notification::make()
                                ->title('Products removed from featured')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('update_category')
                        ->label('Update Category')
                        ->icon('heroicon-o-tag')
                        ->color('info')
                        ->form([
                            Forms\Components\Select::make('category_id')
                                ->label('New Category')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data) {
                            $records->each(fn (Product $record) => $record->update(['category_id' => $data['category_id']]));
                            Notification::make()
                                ->title('Product categories updated successfully')
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
            ])
            ->defaultSort('created_at', 'desc')
            ->paginationPageOptions([10, 25, 50, 100])
            ->defaultPaginationPageOption(25)
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistFiltersInSession();
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
