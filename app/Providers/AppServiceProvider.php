<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\SiteContentService;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SiteContentService::class);
    }

    public function boot(): void
    {
        //
    }
}
