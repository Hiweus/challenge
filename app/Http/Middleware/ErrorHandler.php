<?php

namespace App\Http\Middleware;

use Closure;


use Illuminate\Http\Request;

class ErrorHandler
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
        $response = $next($request);
        
        if (!empty($response->exception) && $response->exception instanceof \Illuminate\Validation\ValidationException) {
            return response([
                'message' => $response->exception->errors()
            ], 400);
        }
        
        if (!empty($response->exception)) {
            return response([
                'message' => env('APP_DEBUG') ? $response->exception->getMessage() : 'Internal error enable debug mode to visualize'
            ], 500);
        }
        
        return $response;
    }
}


