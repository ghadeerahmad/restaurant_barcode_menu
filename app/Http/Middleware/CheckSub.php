<?php

namespace App\Http\Middleware;

use App\Models\Store;
use Closure;
use Illuminate\Http\Request;

class CheckSub
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $store_id = get_current_store();
        if($store_id == null) return redirect('store/create');
        $store = Store::find($store_id);
        if ($store->sub_end > date('Y-m-d'))
            return $next($request);
        return redirect('store/sub_end');
    }
}
