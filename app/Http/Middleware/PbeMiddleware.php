<?php

namespace App\Http\Middleware;

use App\Exceptions\PbeNotAuthenticatedException;
use App\Exceptions\PbeNotAuthorizedException;
use App\Model\User;
use Closure;

class PbeMiddleware
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
        if (empty($request->header('token'))) {
            #Kondisi ketika token tidak dikirim melalui header
            throw new PbeNotAuthorizedException();

        }
        #Kondisi token tidak kosong
        $token = request()->header('token');
        $user = User::where('token', '=', $token)->first();

        if ($user == null) {
            throw new PbeNotAuthenticatedException();
        }

        #Kondisi ketika token nya ada
        $request->user = $user;
        return $next($request);
    }
}
