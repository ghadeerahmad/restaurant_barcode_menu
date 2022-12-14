<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class SiteRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = User::with(['site_privilege'])->find(auth()->user()->id);
        $roles = $user->site_privilege->roles;
        foreach ($roles as $rl)
            if ($rl->site_role->code == $role)
                return $next($request);
        return abort(403);
    }
}
