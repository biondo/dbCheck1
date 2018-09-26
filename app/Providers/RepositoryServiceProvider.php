<?php

namespace DoubleCheck\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \DoubleCheck\Repositories\ProjectRepository::class,
            \DoubleCheck\Repositories\ProjectRepositoryEloquent::class
        );
        $this->app->bind(
            \DoubleCheck\Repositories\ProjectNoteRepository::class,
            \DoubleCheck\Repositories\ProjectNoteRepositoryEloquent::class
        );
        $this->app->bind(
            \DoubleCheck\Repositories\UserRepository::class,
            \DoubleCheck\Repositories\UserRepositoryEloquent::class
        );
        //:end-bindings:
    }
}
