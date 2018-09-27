<?php

namespace DoubleCheck\Providers;

use DoubleCheck\Repositories\ClientRepository;
use DoubleCheck\Repositories\ClientRepositoryEloquent;
use DoubleCheck\Repositories\ProjectRepository;
use DoubleCheck\Repositories\ProjectRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class DoubleCheckRepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UserRepository::class,
            UserRepositoryEloquent::class
        );

        $this->app->bind(
            ClientRepository::class,
            ClientRepositoryEloquent::class
        );
        $this->app->bind(
            ProjectRepository::class,
            ProjectRepositoryEloquent::class
        );
        $this->app->bind(
            \DoubleCheck\Repositories\ProjectNoteRepository::class,
            \DoubleCheck\Repositories\ProjectNoteRepositoryEloquent::class
        );

    }
}
