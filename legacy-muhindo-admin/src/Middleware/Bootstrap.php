<?php

namespace Muhindo\Admin\Middleware;

use Closure;
use Muhindo\Admin\Facades\Admin;
use Illuminate\Http\Request;

class Bootstrap
{
    public function handle(Request $request, Closure $next)
    {
        Admin::bootstrap();

        return $next($request);
    }
}
