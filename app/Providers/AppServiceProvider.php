<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        Role::macro('company', function () {
            return $this->belongsTo(\App\Models\Company::class, 'id', 'id')->whereRaw('1=0');
        });
    }
}
