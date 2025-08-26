<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\Category;
use Filament\Widgets\ChartWidget;

class ProductsChart extends ChartWidget
{
    protected static ?string $heading = 'Products by Category';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        // Cache for 1 hour to improve performance
        return cache()->remember('products_chart_data', 3600, function () {
            $categories = Category::withCount('products')
                ->select(['id', 'name'])
                ->get();
            
            $labels = [];
            $data = [];
            $colors = [
                'rgba(255, 99, 132, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 205, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(255, 159, 64, 0.8)',
                'rgba(199, 199, 199, 0.8)',
                'rgba(83, 102, 255, 0.8)',
            ];

            foreach ($categories as $index => $category) {
                $labels[] = $category->getTranslation('name', 'en') ?? $category->name;
                $data[] = $category->products_count;
            }

            return [
                'datasets' => [
                    [
                        'label' => 'Products',
                        'data' => $data,
                        'backgroundColor' => array_slice($colors, 0, count($data)),
                        'borderColor' => array_map(function($color) {
                            return str_replace('0.8', '1', $color);
                        }, array_slice($colors, 0, count($data))),
                        'borderWidth' => 1,
                    ],
                ],
                'labels' => $labels,
            ];
        });
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
            'responsive' => true,
            'maintainAspectRatio' => false,
        ];
    }
}