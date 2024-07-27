<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;


class SetDefaultLocaleForUrls
{
    public function handle($request, Closure $next)
    {
        URL::defaults(['locale' => '']);

        if(app()->getLocale() != config('app.fallback_locale')){
            URL::defaults(['locale' => app()->getLocale()]);
        }

        return $next($request);
    }
}