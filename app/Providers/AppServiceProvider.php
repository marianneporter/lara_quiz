<?php

namespace App\Providers;

use App\Services\QuizService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(QuizService::class, function ($app) {
            return new QuizService();
        });
    }
    

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
