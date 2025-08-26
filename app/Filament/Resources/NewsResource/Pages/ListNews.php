<?php

namespace App\Filament\Resources\NewsResource\Pages;

use App\Filament\Resources\NewsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListNews extends ListRecords
{
    protected static string $resource = NewsResource::class;

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->select([
                'news.id',
                'news.title',
                'news.author',
                'news.published_at',
                'news.is_active',
                'news.is_featured',
                'news.views_count',
                'news.created_at',
                'news.image'
            ]);
    }

    public function getDefaultTableRecordsPerPageSelectOption(): int
    {
        return 15; // Optimized for performance
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
