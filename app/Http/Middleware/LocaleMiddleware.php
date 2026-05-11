<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LocaleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Si la session contient 'locale', on l'applique, sinon valeur par défaut
        app()->setLocale(session('locale', config('app.locale')));

        return $next($request);
    }
}