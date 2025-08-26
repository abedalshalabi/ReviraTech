<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use App\Models\News;
use App\Models\Agent;
use App\Models\Setting;

class HomeController extends Controller
{
    /**
     * Display the homepage
     */
    public function index($locale = null)
    {
        $data = [
            'sliders' => Slider::getActiveSliders(),
            'featuredProducts' => Product::with('category')->featured()->active()->limit(8)->get(),
            'newProducts' => Product::with('category')->new()->active()->limit(4)->get(),
            'bestsellerProducts' => Product::with('category')->bestseller()->active()->limit(6)->get(),
            'featuredCategories' => Category::with('children')->featured()->active()->limit(6)->get(),
            'latestNews' => News::active()->published()->recent(6)->get(),
            'agents' => Agent::active()->orderBy('sort_order')->limit(12)->get(),
            'settings' => Setting::getAllAsArray(),
        ];

        return view('home', $data);
    }

    /**
     * Display products listing page
     */
    public function products($locale = null, Request $request = null)
    {
        // Handle both localized and non-localized routes
        if ($request === null && $locale instanceof Request) {
            $request = $locale;
            $locale = null;
        }
        
        if ($request === null) {
            $request = request();
        }
        
        $query = Product::with('category')->active();

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Filter by price range
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sort products
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'popular':
                $query->orderBy('views_count', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(12);
        $categories = Category::with('children')->active()->root()->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Display single product page
     */
    public function product($locale = null, $slug = null)
    {
        // Handle both localized and non-localized routes
        if ($slug === null) {
            $slug = $locale;
            $locale = null;
        }
        
        $product = Product::with('category')->where('slug', $slug)->active()->firstOrFail();
        
        // Increment views count
        $product->incrementViews();
        
        // Get related products with eager loading to avoid N+1 queries
        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(6)
            ->get();
        
        // Get settings for the view
        $settings = Setting::getAllAsArray();
        
        return view('products.show', compact('product', 'relatedProducts', 'settings'));
    }

    /**
     * Display news listing page
     */
    public function news($locale = null)
    {
        $news = News::active()->published()->orderBy('published_at', 'desc')->paginate(9);
        
        return view('news.index', compact('news'));
    }

    /**
     * Display single news page
     */
    public function newsShow($locale = null, $slug = null)
    {
        // Handle both localized and non-localized routes
        // For non-localized routes: /news/{slug} -> $locale contains the slug, $slug is null
        // For localized routes: /{locale}/news/{slug} -> $locale contains locale, $slug contains slug
        if ($slug === null) {
            // This is a non-localized route, so $locale actually contains the slug
            $slug = $locale;
            $locale = null;
        }
        // If $slug is not null, this is a localized route and we keep both parameters as they are
        
        $news = News::where('slug', $slug)->active()->published()->firstOrFail();
        
        // Increment views count
        $news->incrementViews();
        
        $relatedNews = $news->getRelatedNews();
        
        return view('news.show', compact('news', 'relatedNews'));
    }

    /**
     * Display agents page
     */
    public function agents($locale = null)
    {
        $agents = Agent::active()->orderBy('sort_order')->get();
        
        return view('agents.index', compact('agents'));
    }

    /**
     * Display contact page
     */
    public function contact($locale = null)
    {
        $settings = Setting::getAllAsArray();
        
        return view('contact', compact('settings'));
    }

    /**
     * Display about page
     */
    public function about($locale = null)
    {
        $page = \App\Models\Page::where('slug', 'about')->active()->first();
        
        return view('about', compact('page'));
    }
}
