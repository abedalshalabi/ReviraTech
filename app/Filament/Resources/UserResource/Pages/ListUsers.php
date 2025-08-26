<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->select([
                'users.id',
                'users.name',
                'users.email',
                'users.email_verified_at',
                'users.created_at'
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