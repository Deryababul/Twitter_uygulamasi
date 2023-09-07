<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // app/Http/Middleware/CheckUserAuthentication.php

public function handle($request, Closure $next)
{
    if (!auth()->check()) {
        return "kullanici kayıtlı degil";
    }
    
    return $next($request);
}

}
