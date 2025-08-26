<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class PageViewsChart extends ChartWidget
{
    protected static ?string $heading = 'Page Views';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        // Cache for 30 minutes to improve performance
        return cache()->remember('page_views_chart_data', 1800, function () {
            $data = [];
            $labels = [];
            
            // Get data for the last 14 days (reduced from 30 for better performance)
            for ($i = 13; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $labels[] = $date->format('M j');
                $data[] = PageView::whereDate('date', $date)->count();
            }

            return [
                'datasets' => [
                    [
                        'label' => 'Page Views',
                        'data' => $data,
                        'borderColor' => 'rgb(59, 130, 246)',
                        'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                        'fill' => true,
                    ],
                ],
                'labels' => $labels,
            ];
        });
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}