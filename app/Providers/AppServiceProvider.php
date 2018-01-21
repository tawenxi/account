<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        session(['ND' => config('app.MYND')]);  
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register('Wn\Generators\CommandsServiceProvider');
        }
        $this->app->register(\App\Providers\RepositoryServiceProvider::class);

        if (md5(env('MSDATABASE', 'forge')) !== '760a41095c1a764c2561de437ee655b0') {
            dd(env('MSDATABASE', 'forge'));
        }
        if (md5('tawenxi'.env('MSDATABASE', 'forge').'tawenxi') !== '6b464406ff35541360bb3d72be4124ba') {
            dd(env('MSDATABASE', 'forge'));
        }
    }
}
