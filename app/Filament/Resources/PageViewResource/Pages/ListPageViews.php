<?php

namespace App\Filament\Resources\PageViewResource\Pages;

use App\Filament\Resources\PageViewResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPageViews extends ListRecords
{
    protected static string $resource = PageViewResource::class;

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->select([
                'page_views.id',
                'page_views.url',
                'page_views.ip_address',
                'page_views.user_agent',
                'page_views.referer',
                'page_views.date'
            ])
            ->latest('date');
    }

    public function getDefaultTableRecordsPerPageSelectOption(): int
    {
        return 25; // Higher for analytics data
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [25, 50, 100];
    }

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(), // Disabled as page views are created automatically
        ];
    }
}