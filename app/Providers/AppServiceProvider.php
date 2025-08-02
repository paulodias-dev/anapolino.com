<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

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
        Schema::defaultStringLength(191);

        // Define macro para permitir defaultTableEngine()
        Builder::macro('defaultTableEngine', function (string $engine) {
            Blueprint::macro('useDefaultEngine', function () use ($engine) {
                $this->engine = $engine;
            });
        });

        // Define o uso automático de InnoDB em todas as tabelas
        Builder::defaultTableEngine('InnoDB');
    }
}
