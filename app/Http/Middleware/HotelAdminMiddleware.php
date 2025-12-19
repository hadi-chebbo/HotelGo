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
        //checks authentication
        if(!$request->user()){
            return response()->json([
                'message' => 'Unauthorized'
            ],401);
        }
        //checks the role
        if($request->user()->role != 2){
            return response()->json([
                'message' => 'Forbidden'
            ],403);
        }

        //checks for associated hotel presence
        if (!$request->user()->hotel) {
            return response()->json([
                'message' => 'No hotel associated with this account'
            ], 403);
        }

        return $next($request);
    }
}
