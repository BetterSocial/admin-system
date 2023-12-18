<?php

namespace App\Providers;

use App\Repositories\DomainRepository;
use App\Repositories\DomainRepositoryImpl;
use App\Services\ApiKeyService;
use App\Services\ChatGetStreamService;
use App\Services\FeedGetStreamService;
use App\Services\ImageService;
use App\Services\ImageServiceImpl;
use App\Services\UserService;
use App\Services\UserServiceImpl;
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

        $this->app->singleton(ChatGetStreamService::class, function () {
            return new ChatGetStreamService();
        });

        $this->app->singleton(ImageService::class, ImageServiceImpl::class);

        $this->app->singleton(UserService::class, function ($app) {
            $apiKeyService = $app->make(ApiKeyService::class);
            return new UserServiceImpl($apiKeyService);
        });

        $this->app->singleton(DomainRepository::class, DomainRepositoryImpl::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
