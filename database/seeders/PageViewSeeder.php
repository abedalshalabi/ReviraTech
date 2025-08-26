<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PageView;
use Carbon\Carbon;
use Faker\Factory as Faker;

class PageViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // Common URLs for an industrial website
        $urls = [
            'http://127.0.0.1:8000/',
            'http://127.0.0.1:8000/about',
            'http://127.0.0.1:8000/services',
            'http://127.0.0.1:8000/products',
            'http://127.0.0.1:8000/contact',
            'http://127.0.0.1:8000/projects',
            'http://127.0.0.1:8000/blog',
            'http://127.0.0.1:8000/careers'
        ];
        
        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15'
        ];
        
        // Generate data for the last 6 months
        for ($month = 5; $month >= 0; $month--) {
            $startDate = Carbon::now()->subMonths($month)->startOfMonth();
            $endDate = Carbon::now()->subMonths($month)->endOfMonth();
            
            // Generate varying number of views per month (more recent = more views)
            $baseViews = 200 + (5 - $month) * 50; // 200-450 views per month
            $dailyViews = $baseViews / $startDate->daysInMonth;
            
            for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
                // Weekend traffic is typically lower
                $multiplier = $date->isWeekend() ? 0.6 : 1.0;
                $viewsToday = round($dailyViews * $multiplier * $faker->numberBetween(80, 120) / 100);
                
                for ($i = 0; $i < $viewsToday; $i++) {
                    // Create sessions (some users visit multiple pages)
                    $sessionId = $faker->uuid();
                    $ipAddress = $faker->ipv4();
                    $userAgent = $faker->randomElement($userAgents);
                    $pagesInSession = $faker->numberBetween(1, 5);
                    
                    for ($page = 0; $page < $pagesInSession; $page++) {
                        PageView::create([
                            'url' => $faker->randomElement($urls),
                            'ip_address' => $ipAddress,
                            'user_agent' => $userAgent,
                            'referer' => $page === 0 ? $faker->optional(0.7)->randomElement([
                                'https://google.com',
                                'https://bing.com',
                                'https://linkedin.com',
                                'https://facebook.com'
                            ]) : null,
                            'session_id' => $sessionId,
                            'date' => $date->copy()->addHours($faker->numberBetween(8, 18))->addMinutes($faker->numberBetween(0, 59)),
                            'created_at' => $date->copy()->addHours($faker->numberBetween(8, 18))->addMinutes($faker->numberBetween(0, 59)),
                            'updated_at' => $date->copy()->addHours($faker->numberBetween(8, 18))->addMinutes($faker->numberBetween(0, 59))
                        ]);
                        
                        // Add some delay between page views in the same session
                        if ($page < $pagesInSession - 1) {
                            $date->addMinutes($faker->numberBetween(1, 10));
                        }
                    }
                }
            }
        }
        
        $this->command->info('Generated ' . PageView::count() . ' page view records.');
    }
}
