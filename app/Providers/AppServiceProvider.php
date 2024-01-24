<?php

namespace App\Providers;

use App\Services\QuizService;
use App\Services\QuizParamsService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(QuizParamsService::class, function ($app) {
            return new QuizParamsService();
        });
    
        $this->app->singleton(QuizService::class, function ($app) {
            return new QuizService($app->make(QuizParamsService::class));
        });
    }    

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }     
    }
}
