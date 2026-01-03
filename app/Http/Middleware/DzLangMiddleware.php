<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class DzLangMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        $availableLangs = config('constants.available_langs');
        $setLang = !empty($_COOKIE['w3cms_locale']) ? $_COOKIE['w3cms_locale'] : config('Site.w3cms_locale');

        if(array_key_exists($setLang, $availableLangs)){
            app()->setLocale($setLang);
        }

        return $next($request);
    }
}
