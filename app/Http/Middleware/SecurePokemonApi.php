<?php

namespace App\Http\Middleware;

use Closure;

class SecurePokemonApi
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
        // Esta autenticación es basica, ya que para hacerla mas robusta se puede utilizar JWT
        if ($request->header('apiKey') === 'v@m0s_4_p@2@r_3st4_pru3b4') {
            return $next($request);
        }else{
            return response()->json(["message 401", "Authentication Required!"], 401);
        }
    }
}
