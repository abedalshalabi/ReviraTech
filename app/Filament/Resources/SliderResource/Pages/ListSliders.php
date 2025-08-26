<?php

namespace App\Filament\Resources\SliderResource\Pages;

use App\Filament\Resources\SliderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListSliders extends ListRecords
{
    protected static string $resource = SliderResource::class;

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->select([
                'sliders.id',
                'sliders.title',
                'sliders.subtitle',
                'sliders.button_text',
                'sliders.button_url',
                'sliders.is_active',
                'sliders.sort_order',
                'sliders.created_at'
            ])
            ->orderBy('sort_order');
    }

    public function getDefaultTableRecordsPerPageSelectOption(): int
    {
        return 10; // Sliders are usually fewer
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
