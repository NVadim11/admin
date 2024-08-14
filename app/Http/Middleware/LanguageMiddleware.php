<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


class LanguageMiddleware
{

    public function handle(Request $request, Closure $next)
    {


        if ($this->isLanguageSegment($request->segment(1)) ) {

            if($request->segment(1) == config('app.fallback_locale')){
                $segments = $request->segments();
                unset($segments[0]);
                return redirect(implode('/', $segments), 301);
            }

            app()->setLocale($request->segment(1));

        };
//
//        // Check if the first segment matches a language code
//        if (!in_array($request->segment(1), config('translatable.locales')) ) {
//
//            // Store segments in array
//            $segments = $request->segments();
//
//            // Set the default language code as the first segment
//            $segments = array_prepend($segments, config('app.fallback_locale'));
//
//            // Redirect to the correct url
//            return redirect()->to(implode('/', $segments));
//        }
//
//        app()->setLocale($request->segment(1));


        return $next($request);
    }

    private function isLanguageSegment(string $segment = null)
    {
        return in_array($segment, config('translatable.locales'));
    }
}