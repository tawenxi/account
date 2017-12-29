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
        //session()->flush();
        //session(['ND' => '2017']);
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

        if (md5(env('MSDATABASE', 'forge')) !== 'e0d4bde6459bae1f47e53d581f7bc113') {
            dd(env('MSDATABASE', 'forge'));
        }
        if (md5('tawenxi'.env('MSDATABASE', 'forge').'tawenxi') !== 'ae8aaef2f3bcac0111a6614fe64a027e') {
            dd(env('MSDATABASE', 'forge'));
        }
    }
}
