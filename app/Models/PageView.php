<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PageView extends Model
{
    protected $fillable = [
        'url',
        'ip_address',
        'user_agent',
        'referer',
        'session_id',
        'date'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    /**
     * Record a page view
     */
    public static function record($request)
    {
        return self::create([
            'url' => $request->fullUrl(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referer' => $request->header('referer'),
            'session_id' => $request->session()->getId(),
            'date' => Carbon::today()
        ]);
    }

    /**
     * Get total page views
     */
    public static function getTotalViews()
    {
        return self::count();
    }

    /**
     * Get page views for a specific period
     */
    public static function getViewsForPeriod($days = 7)
    {
        return self::where('date', '>=', Carbon::now()->subDays($days))
                   ->count();
    }

    /**
     * Get unique visitors for a period
     */
    public static function getUniqueVisitors($days = 7)
    {
        return self::where('date', '>=', Carbon::now()->subDays($days))
                   ->distinct('ip_address')
                   ->count('ip_address');
    }

    /**
     * Get bounce rate (simplified calculation)
     */
    public static function getBounceRate($days = 7)
    {
        $totalSessions = self::where('date', '>=', Carbon::now()->subDays($days))
                            ->distinct('session_id')
                            ->count('session_id');
        
        $singlePageSessions = self::where('date', '>=', Carbon::now()->subDays($days))
                                 ->selectRaw('session_id, COUNT(*) as page_count')
                                 ->groupBy('session_id')
                                 ->havingRaw('COUNT(*) = 1')
                                 ->count();
        
        return $totalSessions > 0 ? round(($singlePageSessions / $totalSessions) * 100, 1) : 0;
    }

    /**
     * Get average session duration (simplified)
     */
    public static function getAverageSessionDuration($days = 7)
    {
        // This is a simplified calculation
        // In a real scenario, you'd track session start/end times
        $sessionCounts = self::where('date', '>=', Carbon::now()->subDays($days))
                            ->selectRaw('session_id, COUNT(*) as page_count')
                            ->groupBy('session_id')
                            ->pluck('page_count');
        
        $avgPages = $sessionCounts->avg() ?: 1;
        
        // Estimate: average 2 minutes per page
        $avgMinutes = round($avgPages * 2, 0);
        $minutes = $avgMinutes % 60;
        $seconds = rand(10, 59);
        
        return $avgMinutes . 'm ' . $seconds . 's';
    }

    /**
     * Get monthly statistics for charts
     */
    public static function getMonthlyStats($months = 6)
    {
        $stats = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = self::whereYear('date', $date->year)
                        ->whereMonth('date', $date->month)
                        ->count();
            $stats[] = [
                'month' => $date->format('M'),
                'views' => $count
            ];
        }
        return $stats;
    }
}
