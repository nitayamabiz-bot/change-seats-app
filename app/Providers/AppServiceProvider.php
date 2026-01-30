<?php

namespace App\Providers;

use App\Console\Commands\TddWatchCommand;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\ServiceProvider;

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
        $this->commands([
            TddWatchCommand::class,
        ]);

        RedirectIfAuthenticated::redirectUsing(fn ($request) => route('home'));
    }
}
