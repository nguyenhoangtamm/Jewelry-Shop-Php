<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share top categories for navigation in user views (cached 10 minutes)
        View::composer('user.*', function ($view) {
            $navCategories = Cache::remember('nav_categories_top7', 600, function () {
                return Category::query()
                    ->orderBy('name')
                    ->limit(7)
                    ->get(['id', 'name']);
            });

            $view->with('navCategories', $navCategories);
        });
    }
}
