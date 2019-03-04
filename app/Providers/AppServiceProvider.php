<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

//interfaces
use Domain\Layers\Data\Contracts\Repositories\BookRepository as BookRepositoryContract;
use Domain\Layers\Data\Contracts\Repositories\PublisherRepository as PublisherRepositoryContract;
use Domain\Layers\Data\Contracts\Repositories\GenreRepository as GenreRepositoryContract;
use Domain\Layers\Data\Contracts\Repositories\AuthorRepository as AuthorRepositoryContract;

use Domain\Layers\Services\Business\Contracts\BaseService as BaseServiceContract;
use Domain\Layers\Services\Business\Contracts\BookService as BookServiceContract;

use Domain\Layers\Services\Validation\Contracts\Validator as ValidatorContract;

//classes
use Domain\Frameworks\Laravel\Data\Repositories\BookRepository;
use Domain\Frameworks\Laravel\Data\Repositories\PublisherRepository;
use Domain\Frameworks\Laravel\Data\Repositories\GenreRepository;
use Domain\Frameworks\Laravel\Data\Repositories\AuthorRepository;

use Domain\Layers\Services\Business\BookService;
use Domain\Frameworks\Laravel\Services\Business\BaseBusinessService as BaseService;

use Domain\Frameworks\Laravel\Services\Validation\ValidationAdapter as Validator;


class AppServiceProvider extends ServiceProvider
{

    public $singletons = [

        //repositories
        BookRepositoryContract::class => BookRepository::class,
        PublisherRepositoryContract::class => PublisherRepository::class,
        GenreRepositoryContract::class => GenreRepository::class,
        AuthorRepositoryContract::class => AuthorRepository::class,

        //services
        BaseServiceContract::class => BaseService::class,
        BookServiceContract::class => BookService::class,
    ];

    public $bindings = [
        ValidatorContract::class => Validator::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
