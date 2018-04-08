<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\CatRepository::class, \App\Repositories\CatRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\DogRepository::class, \App\Repositories\DogRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Dog2Repository::class, \App\Repositories\Dog2RepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SalaryRepository::class, \App\Repositories\SalaryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ZfpzRepository::class, \App\Repositories\ZfpzRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ZbRepository::class, \App\Repositories\ZbRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\GuzzledbRepository::class, \App\Repositories\GuzzledbRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ZjzbRepository::class, \App\Repositories\ZjzbRepositoryEloquent::class);
        //:end-bindings:
    }
}
