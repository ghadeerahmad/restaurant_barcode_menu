<?php

namespace App\Http\Middleware;

use App\Models\Store;
use Closure;
use Illuminate\Http\Request;

class PlanRole
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
        if ($store_id == null) return abort(404);
        $store = Store::with(['plan'])->find($store_id);
        $roles = $store->plan->plan_roles;
        foreach ($roles as $r)
            if ($r->role->code == $role)
                return $next($request);
        return abort(403);
    }
}
