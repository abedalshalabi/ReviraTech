<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Filters Form -->
        <div class="bg-white rounded-lg shadow p-6">
            {{ $this->form }}
            
            <div class="mt-4">
                <x-filament::button wire:click="generateReport" type="button">
                    Generate Report
                </x-filament::button>
            </div>
        </div>

        @if($reportType === 'overview')
            <!-- Overview Stats -->
            @php $stats = $this->getOverviewStats(); @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-heroicon-o-cube class="h-8 w-8 text-green-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Products</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_products']) }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-heroicon-o-users class="h-8 w-8 text-blue-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Users</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_users']) }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-heroicon-o-eye class="h-8 w-8 text-purple-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Page Views</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_page_views']) }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-heroicon-o-newspaper class="h-8 w-8 text-yellow-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">News Articles</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_news']) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Additional Overview Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Product Statistics</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Active Products:</span>
                            <span class="text-sm font-medium">{{ number_format($stats['active_products']) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Featured Products:</span>
                            <span class="text-sm font-medium">{{ number_format($stats['featured_products']) }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">User Statistics</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">New Users (Period):</span>
                            <span class="text-sm font-medium">{{ number_format($stats['new_users']) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Unique Visitors:</span>
                            <span class="text-sm font-medium">{{ number_format($stats['unique_visitors']) }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Content Statistics</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Published News:</span>
                            <span class="text-sm font-medium">{{ number_format($stats['published_news']) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Total Agents:</span>
                            <span class="text-sm font-medium">{{ number_format($stats['total_agents']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($reportType === 'products')
            <!-- Products Analytics -->
            @php $analytics = $this->getProductsAnalytics(); @endphp
            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Products by Category</h3>
                    <div class="space-y-2">
                        @foreach($analytics['products_by_category'] as $category)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">{{ $category->getTranslation('name', 'en') ?? $category->name }}</span>
                                <span class="text-sm font-medium">{{ $category->products_count }} products</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Products</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Views</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($analytics['recent_products'] as $product)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $product->getTranslation('name', 'en') ?? $product->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            ${{ number_format($product->price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ number_format($product->views) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $product->created_at->format('M j, Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        @if($reportType === 'traffic')
            <!-- Traffic Analytics -->
            @php $analytics = $this->getTrafficAnalytics(); @endphp
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Traffic Summary</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Total Views:</span>
                                <span class="text-sm font-medium">{{ number_format($analytics['total_views']) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Unique Visitors:</span>
                                <span class="text-sm font-medium">{{ number_format($analytics['unique_visitors']) }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Top Pages</h3>
                        <div class="space-y-2">
                            @foreach($analytics['top_pages'] as $page)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 truncate">{{ parse_url($page->url, PHP_URL_PATH) }}</span>
                                    <span class="text-sm font-medium">{{ number_format($page->views) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($reportType === 'users')
            <!-- Users Analytics -->
            @php $analytics = $this->getUsersAnalytics(); @endphp
            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">User Statistics</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Verified Users:</span>
                                <span class="text-sm font-medium">{{ number_format($analytics['verified_users']) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Unverified Users:</span>
                                <span class="text-sm font-medium">{{ number_format($analytics['unverified_users']) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($reportType === 'news')
            <!-- News Analytics -->
            @php $analytics = $this->getNewsAnalytics(); @endphp
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">News Statistics</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Published:</span>
                                <span class="text-sm font-medium">{{ number_format($analytics['published_news']) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Featured:</span>
                                <span class="text-sm font-medium">{{ number_format($analytics['featured_news']) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Drafts:</span>
                                <span class="text-sm font-medium">{{ number_format($analytics['draft_news']) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-filament-panels::page>