<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class DzFrontLangMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $availableLangs = config('lang.default');

        $setLang = $request->session()->has('language') ? $request->session()->get('language') : config('Site.w3cms_locale','en');

        if(array_key_exists($setLang, $availableLangs)){
            app()->setLocale($setLang);
        }

        return $next($request);
    }
}
