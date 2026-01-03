<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        $prefix = request()->route()->getPrefix();

        $url = route('login');
        if(!empty($prefix) && str_contains($prefix, 'admin')) {
            $url = url('admin/login');
        }

        return $request->expectsJson() ? null : $url;
    }
}
