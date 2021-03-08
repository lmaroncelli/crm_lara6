<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ForbiddenIfType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $type)
    {
        $user = Auth::user();

        if ($user && !is_null($type) && $user->type_id == $type) {
            return redirect()->route('home')->with('alert', 'Non hai i permessi !!');
        } else {
            return $next($request);
        }
    }
}
