<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
         // if ($request->input('token') !== 'my-secret-token') {
        if (!Hash::check(env('APP_ID'),$request->bearerToken())) {
           
            $response = [
                'message' => 'Your not have to access this api'
            ];

            return response($response, 500);
        }
        return $next($request);
    }
}
