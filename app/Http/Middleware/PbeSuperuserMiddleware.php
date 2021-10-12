<?php

namespace App\Http\Middleware;

use App\Exceptions\PbeNotAuthorizedException;
use Closure;

class PbeSuperuserMiddleware
{
    /**
     * @throws PbeNotAuthorizedException
     */
    public function handle($request, Closure $next)
    {
        if ($request->user->role != 'superuser') {
            throw new PbeNotAuthorizedException();
        }
        return $next($request);
    }
}
