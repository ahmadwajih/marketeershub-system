<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class DashboardMiddleware
{
    /**
     * Handle an incoming request.
     * @Target check user is admin and can log in if status column active
     * @param Request $request
     * @param Closure $next
     * @return Application|RedirectResponse|Redirector|mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (\auth()->user() && auth()->user()->position != "publisher") {
            return $next($request);
        }
        return redirect('/publisher/home');
    }
}
