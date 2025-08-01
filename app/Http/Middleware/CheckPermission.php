<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    use ApiResponseTrait;
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = auth()->user();

        if (! $user || ! $user->hasPermission($permission)) {
            return $this->errorResponse('Forbidden',403);
        }

        return $next($request);
    }
}
