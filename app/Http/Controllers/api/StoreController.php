<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * get store details
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate(['store' => 'required|exists:stores,id']);
        $store = Store::accepted()->with([
            'product_categories',
            'currency',
            'work_days'
        ])->findOrFail($request['store']);
        return success_response($store);
    }
}
