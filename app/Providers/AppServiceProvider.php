<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
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
        // Compartilha categorias ativas e ordenadas com todas as views (navbar)
        View::composer('*', function ($view) {
            try {
                $navCategories = Category::query()->active()->ordered()->take(12)->get(['id','name','slug']);
                $view->with('navCategories', $navCategories);
            } catch (\Throwable $e) {
                // Em cenários de instalação/migração, ignore erros de tabela inexistente
            }
        });
    }
}
