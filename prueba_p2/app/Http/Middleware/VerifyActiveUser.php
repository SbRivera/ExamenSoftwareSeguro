<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyActiveUser
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->is_active) {
            $reason = Auth::user()->deactivation_reason ?: 'Tu cuenta ha sido desactivada.';
            Auth::logout();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => "Tu cuenta está desactivada. Motivo: {$reason}"
                ]);
        }

        return $next($request);
    }
}
