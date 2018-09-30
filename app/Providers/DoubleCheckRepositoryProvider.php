<?php

namespace DoubleCheck\Providers;

use DoubleCheck\Repositories\ClientRepository;
use DoubleCheck\Repositories\ClientRepositoryEloquent;
use DoubleCheck\Repositories\ProjectFileRepository;
use DoubleCheck\Repositories\ProjectFileRepositoryEloquent;
use DoubleCheck\Repositories\ProjectNoteRepository;
use DoubleCheck\Repositories\ProjectNoteRepositoryEloquent;
use DoubleCheck\Repositories\ProjectRepository;
use DoubleCheck\Repositories\ProjectRepositoryEloquent;
use DoubleCheck\Repositories\UserRepository;
use DoubleCheck\Repositories\UserRepositoryEloquent;
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
            ProjectNoteRepository::class,
            ProjectNoteRepositoryEloquent::class
        );
        $this->app->bind(
            ProjectFileRepository::class,
            ProjectFileRepositoryEloquent::class
        );

    }
}
