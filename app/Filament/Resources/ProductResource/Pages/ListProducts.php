<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->with(['category'])
            ->select([
                'products.id',
                'products.name',
                'products.sku',
                'products.brand',
                'products.price',
                'products.category_id',
                'products.is_active',
                'products.is_featured',
                'products.is_new',
                'products.created_at',
                'products.image'
            ])
            ->orderBy('products.created_at', 'desc');
    }

    public function getDefaultTableRecordsPerPageSelectOption(): int
    {
        return 15; // Reduced from 25 for better performance
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 15, 25, 50]; // Optimized pagination options
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
