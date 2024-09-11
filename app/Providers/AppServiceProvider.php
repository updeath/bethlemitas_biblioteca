<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Book_statu;

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
        // Hacer que $book_status esté disponible en todas las vistas o en vistas específicas
        View::composer('*', function ($view) {
            $view->with('book_status', Book_statu::all());
        });
    }
}
