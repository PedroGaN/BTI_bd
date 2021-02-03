<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\UserController;

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
        //FUNCIÓN EN TESTING - DOCU LARAVEL
        /*
        - Comprueba el Token que va en el Header [bearerToken()], con el Token creado al hacer el Login [getRememberToken()] 
        - La función getRememberToken(), está al final del controlador User.
        */

        $apiToken = $request->bearerToken();
        $userToken = User::getRememberToken();

        if($apiToken == $userToken){
            return $next($request);
        } else {
            return response("Operation not allowed", 403);
        }
    }
}
