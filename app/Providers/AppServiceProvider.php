<?php

declare(strict_types=1);

namespace App\Providers;

use App\Domain\Repositories\UserRepository as iUserRepo;
use App\Infrastructure\Repositories\User\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        \Laravel\Sanctum\Sanctum::ignoreMigrations(); // Sanctum無効化

        $this->app->bind(
            iUserRepo::class,
            UserRepository::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // error throw n+1 problem etc...
        Model::shouldBeStrict(! $this->app->isProduction());
    }
}
