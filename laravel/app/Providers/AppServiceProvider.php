<?php

namespace App\Providers;
use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\View;

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
        // JsonResource::withoutWrapping();
        // $categories = Category::all();
        // View::share('categories', $categories);
    }
}
