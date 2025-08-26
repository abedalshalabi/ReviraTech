<?php

namespace App\Providers;

use App\Models\News;
use App\Models\Product;
use App\Models\User;
use App\Policies\NewsPolicy;
use App\Policies\ProductPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Product::class => ProductPolicy::class,
        News::class => NewsPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define additional gates if needed
        Gate::define('access-admin-panel', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('manage-settings', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('view-reports', function (User $user) {
            return $user->hasRole('admin') || $user->hasPermission('view_reports');
        });

        Gate::define('manage-users', function (User $user) {
            return $user->hasRole('admin');
        });
    }
}