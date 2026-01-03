<?php

namespace Modules\Installation\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CanInstall
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (!$this->alreadyInstalled() && !$request->is('install*')) {
            return redirect('install');
        }
        else if ($this->alreadyInstalled() && $request->is('install*'))
        {
            return redirect('admin');
        }

        return $next($request);
    }

    public function alreadyInstalled()
    {
        return file_exists(storage_path('installed'));
    }
}
