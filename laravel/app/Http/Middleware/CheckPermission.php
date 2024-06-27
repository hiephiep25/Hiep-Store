<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class CheckPermission
{
    /**
     * check permission of admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Closure  $next
     * @param  ?string $param
     * @return \Illuminate\Http\Response
     */
    public function handle($request, Closure $next, string $param = '')
    {
        return canAccess($param) ? $next($request) : abort(Response::HTTP_FORBIDDEN);
    }
}
