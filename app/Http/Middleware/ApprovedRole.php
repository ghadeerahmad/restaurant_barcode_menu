<?php

namespace App\Http\Middleware;

use App\Models\Store;
use Closure;
use Illuminate\Http\Request;

class ApprovedRole
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
        $store = Store::find(get_current_store());
        
        if ($store != null) {
            switch ($store->status) {
                case 0;
                    return redirect('store/pending');
                case 2:
                    return redirect('store/deactivated');
            }
        }
        return $next($request);
    }
}
