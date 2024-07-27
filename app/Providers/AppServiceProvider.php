<?php

namespace App\Providers;

use App\Http\Composers\SeoBlocksComposer;
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
        app('router')->bind('locale', function() { return null; });
		view()->composer( ['layouts.particles.seo_blocks'], SeoBlocksComposer::class );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
}
