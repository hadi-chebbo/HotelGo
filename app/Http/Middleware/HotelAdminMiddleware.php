<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HotelAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!request->user()){
            return response()->json([
                'message' => 'Unauthorized'
            ],401);
        }

        if(request->user()->role != 2){
            return respones()->json([
                'message' => 'Forbidden'
            ],403);
        }
        return $next($request);
    }
}
