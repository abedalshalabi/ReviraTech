<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\News;
use App\Models\User;
use App\Models\PageView;
use App\Models\Agent;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        // Cache stats for 1 hour to improve performance and reduce database load
        return cache()->remember('dashboard_stats', 3600, function () {
            return [
                Stat::make('Total Products', Product::count())
                    ->description('Active products in catalog')
                    ->descriptionIcon('heroicon-m-cube')
                    ->color('success'),
                
                Stat::make('Total Users', User::count())
                    ->description('Registered users')
                    ->descriptionIcon('heroicon-m-users')
                    ->color('info'),
                
                Stat::make('Total News', News::count())
                    ->description('Published articles')
                    ->descriptionIcon('heroicon-m-newspaper')
                    ->color('warning'),
                
                Stat::make('Page Views Today', PageView::whereDate('date', today())->count())
                    ->description('Views in the last 24 hours')
                    ->descriptionIcon('heroicon-m-eye')
                    ->color('primary'),
                
                Stat::make('Active Agents', Agent::count())
                    ->description('Total agents')
                    ->descriptionIcon('heroicon-m-building-office')
                    ->color('gray'),
                
                Stat::make('Featured Products', Product::where('is_featured', true)->count())
                    ->description('Products marked as featured')
                    ->descriptionIcon('heroicon-m-star')
                    ->color('amber'),
            ];
        });
    }
}