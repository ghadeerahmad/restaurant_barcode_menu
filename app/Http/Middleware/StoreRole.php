<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\UserStorePrivilege;
use Closure;
use Illuminate\Http\Request;

class StoreRole
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
        $store_id = get_current_store();
        $privilege = UserStorePrivilege::with(['store_privilege'])
        ->where('store_id',$store_id)
        ->where('user_id',auth()->user()->id)
        ->first();
        if($privilege == null) abort(403);
        $roles = $privilege->store_privilege->roles;
        if($roles == null) abort(403);
        foreach ($roles as $rl)
            if ($rl->store_role->code == $role)
                return $next($request);
        return abort(403);
    }
}
