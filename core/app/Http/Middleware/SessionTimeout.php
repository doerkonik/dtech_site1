<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    public function handle(Request $request, Closure $next)
    {
        // Skip for API routes
        if ($request->is('api/*')) {
            return $next($request);
        }

        // Check user session (frontend users)
        if (Auth::check()) {
            $this->checkTimeout($request, 'last_activity_user');
            if (!Auth::check()) {
                return redirect()->route('login')
                    ->with('session_expired', 'Your session has expired. Please log in again.');
            }
        }

        // Check admin session
        if (Auth::guard('admin')->check()) {
            $this->checkAdminTimeout($request);
            if (!Auth::guard('admin')->check()) {
                return redirect()->route('admin.login')
                    ->with('session_expired', 'Your session has expired. Please log in again.');
            }
        }

        return $next($request);
    }

    private function checkTimeout(Request $request, string $sessionKey): void
    {
        $lastActivity = session($sessionKey);
        $timeoutSeconds = config('session.lifetime') * 60;

        if ($lastActivity && (time() - $lastActivity) >= $timeoutSeconds) {
            Auth::logout();
            session()->flush();
            session()->regenerate();
            return;
        }

        session([$sessionKey => time()]);
    }

    private function checkAdminTimeout(Request $request): void
    {
        $lastActivity = session('last_activity_admin');
        $timeoutSeconds = config('session.lifetime') * 60;

        if ($lastActivity && (time() - $lastActivity) >= $timeoutSeconds) {
            Auth::guard('admin')->logout();
            session()->flush();
            session()->regenerate();
            return;
        }

        session(['last_activity_admin' => time()]);
    }
}