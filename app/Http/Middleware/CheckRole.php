<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckRole
{
    /**

     */
    
        public function handle($request, Closure $next, ...$roles)
        {
            $user = Auth::user();
    
            if (!in_array($user->role, $roles)) {
                abort(403, 'Unauthorized action.');
            }
    
            return $next($request);
        }
    
}
