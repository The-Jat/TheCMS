<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Hexadog\ThemesManager\Http\Middleware\ThemeLoader as HexadogThemeLoader;
use Hexadog\ThemesManager\Facades\ThemesManager;

class ThemeLoader extends HexadogThemeLoader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $theme = 'frontend/lemars'): Response
    {
        $theme = ThemesManager::has(config('Theme.select_theme', $theme)) ? config('Theme.select_theme', $theme) : $theme;
        
        if (ThemesManager::has($theme)) {
            if ($request->segment(1) === 'admin') {
                $theme = config('Theme.select_admin_theme', 'admin/zenix');
            }

            return parent::handle($request, $next, $theme);
        }

        return parent::handle($request, $next);
    }
}
