<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\News;
use App\Models\User;
use App\Models\PageView;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class RecentActivitiesWidget extends Widget
{
    protected static string $view = 'filament.widgets.recent-activities';
    
    protected static ?string $heading = 'Recent Activities';
    
    protected static ?int $sort = 4;
    
    protected int | string | array $columnSpan = 'full';
    
    public function getActivities(): Collection
    {
        // Cache the results for 5 minutes to improve performance
        return cache()->remember('recent_activities_widget', 300, function () {
            $activities = collect();

            // Recent products - limit to 5 for better performance
            $recentProducts = Product::latest()
                ->select('id', 'name', 'created_at')
                ->take(5)
                ->get()
                ->map(function ($product) {
                    return (object) [
                        'type' => 'Product',
                        'title' => $product->getTranslation('name', 'en') ?? $product->name ?? 'Untitled Product',
                        'created_at' => $product->created_at,
                    ];
                });

            // Recent news - limit to 5 for better performance
            $recentNews = News::latest()
                ->select('id', 'title', 'created_at')
                ->take(5)
                ->get()
                ->map(function ($news) {
                    return (object) [
                        'type' => 'News',
                        'title' => $news->getTranslation('title', 'en') ?? $news->title ?? 'Untitled News',
                        'created_at' => $news->created_at,
                    ];
                });

            // Recent users - limit to 3 for better performance
            $recentUsers = User::latest()
                ->select('id', 'name', 'created_at')
                ->take(3)
                ->get()
                ->map(function ($user) {
                    return (object) [
                        'type' => 'User',
                        'title' => 'New user: ' . $user->name,
                        'created_at' => $user->created_at,
                    ];
                });

            // Skip page views for now as they might be causing performance issues
            // Can be re-enabled later with proper indexing

            // Combine all activities
            $activities = $activities
                ->merge($recentProducts)
                ->merge($recentNews)
                ->merge($recentUsers)
                ->sortByDesc('created_at')
                ->take(15);

            return $activities;
        });
    }
}