<?php
namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class AccessToModules
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        $name = $request->segment(2);

        if ($name && !$user->has_access_to($name)) {
            abort(403, 'Доступ запрещен');
        }

        return $next($request);
    }
}