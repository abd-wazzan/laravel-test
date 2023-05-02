<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class RouteMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Route::macro('softDeletes', function ($name, $controller) {
            $name = Str::plural($name);
            $modelName = Str::singular($name);
            return Route::prefix($name)
                ->controller($controller)
                ->group(function () use ($name, $modelName) {
                    Route::get('trashed', 'trashed')->name("$name.trashed");
                    Route::patch("{{$modelName}}/restore", 'restore')->name("$name.restore");
                    Route::delete("{{$modelName}}/delete", 'delete')->name("$name.delete");
                });
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
