<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class CustomApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $headers = $request->headers->all();

        if (array_key_exists('x-user-id', $headers) && array_key_exists('x-remember-token', $headers)) {
            $user = User::find($headers['x-user-id'])->first();

            if ($request->wantsJson() && $user) {

                if ($headers['x-remember-token'] === [$user->getRememberToken()] ) {
                    return $next($request);
                }
            }
        }

        return response()->json(['error' => 'Unauthenticated'], 401);
    }
}
