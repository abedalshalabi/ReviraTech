<?php

namespace App\Filament\Pages;

use App\Models\Product;
use App\Models\News;
use App\Models\User;
use App\Models\PageView;
use App\Models\Agent;
use App\Models\Category;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;

class Reports extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    protected static string $view = 'filament.pages.reports';

    public static function canAccess(): bool
    {
        return Gate::allows('view-reports');
    }

    protected static ?string $navigationGroup = 'Analytics';

    protected static ?int $navigationSort = 2;

    public ?array $data = [];
    
    public $startDate;
    public $endDate;
    public $reportType = 'overview';

    public function mount(): void
    {
        $this->startDate = now()->subDays(30)->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        
        $this->form->fill([
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'report_type' => $this->reportType,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Report Filters')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                DatePicker::make('start_date')
                                    ->label('Start Date')
                                    ->default(now()->subDays(30))
                                    ->reactive(),
                                DatePicker::make('end_date')
                                    ->label('End Date')
                                    ->default(now())
                                    ->reactive(),
                                Select::make('report_type')
                                    ->label('Report Type')
                                    ->options([
                                        'overview' => 'Overview',
                                        'products' => 'Products Analytics',
                                        'users' => 'Users Analytics',
                                        'traffic' => 'Traffic Analytics',
                                        'news' => 'News Analytics',
                                    ])
                                    ->default('overview')
                                    ->reactive(),
                            ])
                    ])
            ])
            ->statePath('data');
    }

    public function updated($property)
    {
        if (in_array($property, ['data.start_date', 'data.end_date', 'data.report_type'])) {
            $this->generateReport();
        }
    }

    public function generateReport()
    {
        $startDate = Carbon::parse($this->data['start_date'] ?? $this->startDate);
        $endDate = Carbon::parse($this->data['end_date'] ?? $this->endDate);
        $reportType = $this->data['report_type'] ?? $this->reportType;

        $this->startDate = $startDate->format('Y-m-d');
        $this->endDate = $endDate->format('Y-m-d');
        $this->reportType = $reportType;
    }

    public function getOverviewStats()
    {
        $startDate = Carbon::parse($this->startDate);
        $endDate = Carbon::parse($this->endDate);

        return [
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'featured_products' => Product::where('is_featured', true)->count(),
            'total_users' => User::count(),
            'new_users' => User::whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_news' => News::count(),
            'published_news' => News::where('is_active', true)->count(),
            'total_page_views' => PageView::whereBetween('date', [$startDate, $endDate])->count(),
            'unique_visitors' => PageView::whereBetween('date', [$startDate, $endDate])
                ->distinct('ip_address')->count('ip_address'),
            'total_agents' => Agent::count(),
        ];
    }

    public function getProductsAnalytics()
    {
        $startDate = Carbon::parse($this->startDate);
        $endDate = Carbon::parse($this->endDate);

        return [
            'products_by_category' => Category::withCount('products')->get(),
            'recent_products' => Product::whereBetween('created_at', [$startDate, $endDate])
                ->orderBy('created_at', 'desc')->take(10)->get(),
            'top_viewed_products' => Product::orderBy('views', 'desc')->take(10)->get(),
            'featured_products' => Product::where('is_featured', true)->count(),
            'products_on_sale' => Product::where('sale_price', '>', 0)->count(),
        ];
    }

    public function getUsersAnalytics()
    {
        $startDate = Carbon::parse($this->startDate);
        $endDate = Carbon::parse($this->endDate);

        return [
            'new_users' => User::whereBetween('created_at', [$startDate, $endDate])->get(),
            'verified_users' => User::whereNotNull('email_verified_at')->count(),
            'unverified_users' => User::whereNull('email_verified_at')->count(),
            'users_by_month' => User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', now()->year)
                ->groupBy('month')
                ->get(),
        ];
    }

    public function getTrafficAnalytics()
    {
        $startDate = Carbon::parse($this->startDate);
        $endDate = Carbon::parse($this->endDate);

        return [
            'daily_views' => PageView::selectRaw('DATE(date) as date, COUNT(*) as views')
                ->whereBetween('date', [$startDate, $endDate])
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
            'top_pages' => PageView::selectRaw('url, COUNT(*) as views')
                ->whereBetween('date', [$startDate, $endDate])
                ->groupBy('url')
                ->orderBy('views', 'desc')
                ->take(10)
                ->get(),
            'unique_visitors' => PageView::whereBetween('date', [$startDate, $endDate])
                ->distinct('ip_address')->count('ip_address'),
            'total_views' => PageView::whereBetween('date', [$startDate, $endDate])->count(),
        ];
    }

    public function getNewsAnalytics()
    {
        $startDate = Carbon::parse($this->startDate);
        $endDate = Carbon::parse($this->endDate);

        return [
            'recent_news' => News::whereBetween('created_at', [$startDate, $endDate])
                ->orderBy('created_at', 'desc')->get(),
            'featured_news' => News::where('is_featured', true)->count(),
            'published_news' => News::where('is_active', true)->count(),
            'draft_news' => News::where('is_active', false)->count(),
            'top_viewed_news' => News::orderBy('views', 'desc')->take(10)->get(),
        ];
    }
}