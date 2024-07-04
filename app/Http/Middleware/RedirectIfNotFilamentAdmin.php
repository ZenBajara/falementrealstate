<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class RedirectIfNotFilamentAdmin
{
    use HasRoles;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $auth = Filament::auth();

        if (!$auth->check()) {
            return redirect(Filament::getLoginUrl());
        }

        $user = $auth->user();
        // Redirect based on role
        if ($user->hasRole('admin')) {
            return $next($request);
        } else {
            return redirect('/');
        }
    }
}
