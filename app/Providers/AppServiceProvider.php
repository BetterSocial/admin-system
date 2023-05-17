<?php

namespace App\Providers;

use App\Services\ApiKeyService;
use App\Services\FeedGetStreamService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ApiKeyService::class, function () {
            return new ApiKeyService();
        });

        $this->app->singleton(FeedGetStreamService::class, function () {
            return new FeedGetStreamService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // Schema::defaultStringLength(191);
    }
}
