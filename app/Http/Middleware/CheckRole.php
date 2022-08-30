<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next ,$role='')
    {
       /*if ($request->user() && $request->user()->type != 'admin')
        {
            return new Response(view('unauthorized')->with('role', $request->user()->type));
        }
        return $next($request);*/
    }
}
