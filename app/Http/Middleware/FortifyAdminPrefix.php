<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Hexadog\ThemesManager\Facades\ThemesManager;
use Str;

class FortifyAdminPrefix
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Str::contains($request->getRequestUri(), ['user/confirm-password', 'two-factor-challenge'])) {
            ThemesManager::set(config('Theme.select_admin_theme', 'admin/zenix'));
            config(['themes-manager.symlink_path' => theme_asset('themes')]);
        }
        return $next($request);
    }
}
