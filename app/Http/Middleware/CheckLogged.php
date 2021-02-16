<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Log;

class CheckLogged
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

        $apiToken = $request->bearerToken();

        $user = User::where('api_token', $apiToken)->first();

        if ($user){

            return $next($request);

        } else {
            return response("Invalid token", 401);
        }
    }
}
