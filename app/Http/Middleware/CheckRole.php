<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
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
        if($request->user() === null){
            return response('Você não tem permissão para visualizar esta página', 401);
        }

        $actions = $request->route()->getAction();
        $roles = !empty($actions['roles']) ? $actions['roles'] : null;

        if($request->user()->hasAnyRole($roles)) {
            return $next($request);
        }

        return response('Você não tem permissão para visualizar esta página', 401);

        
    }
}
