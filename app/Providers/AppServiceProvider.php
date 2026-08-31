<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('path.public', function () {
            return realpath(base_path('../../public_html/simpledelivery'))
                ?: base_path('../../public_html/simpledelivery');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // bootstrap pagination
        Paginator::useBootstrap();
        Schema::defaultStringLength(150);
    }
}
