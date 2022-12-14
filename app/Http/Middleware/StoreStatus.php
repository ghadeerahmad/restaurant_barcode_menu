<?php

namespace App\Http\Middleware;

use App\Models\Store;
use Closure;
use Illuminate\Http\Request;

class StoreStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $type)
    {
        switch ($type) {
            case 'deactivated':
                $store_id = get_current_store();
                if ($store_id != null) {
                    $store = Store::find($store_id);
                    if ($store->status == 1) return redirect('store/dashboard');
                }
                break;
            case 'sub_end':
                $store_id = get_current_store();
                if ($store_id != null) {
                    $store = Store::find($store_id);
                    if ($store->sub_end > date('Y-m-d'))
                        return redirect('store/dashboard');
                }
                break;
        }
        return $next($request);
    }
}
