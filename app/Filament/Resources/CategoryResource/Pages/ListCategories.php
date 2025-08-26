<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getTableQuery(): Builder
    {
        // Removed withCount('products') to improve performance
        // Product count can be added back later with proper caching if needed
        return parent::getTableQuery()
            ->select([
                'categories.id',
                'categories.name',
                'categories.slug',
                'categories.description',
                'categories.is_active',
                'categories.sort_order',
                'categories.created_at'
            ]);
    }

    public function getDefaultTableRecordsPerPageSelectOption(): int
    {
        return 15;
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 15, 25, 50];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
