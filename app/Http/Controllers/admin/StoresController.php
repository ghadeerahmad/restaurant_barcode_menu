<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StoresController extends Controller
{
    public function change_status(Request $request)
    {
        get_locale();
        request()->validate([
            'store_id' => 'required',
        ]);
        $store = Store::find($request['store_id']);
        $status = 2;
        if ($store->status == 2) $status = 1;
        $store->status = $status;
        $store->save();
        return response()->json(['success' => $status == 1 ? __('messages.enabled') : __('messages.disabled')]);
    }
    public function edit_plan($id)
    {
        get_locale();
        $store = Store::find($id);
        $plans = Plan::all();
        return view('admin.store.edit', ['store' => $store, 'plans' => $plans]);
    }
    public function update_plan(Request $request, $id)
    {
        get_locale();
        $store = Store::find($id);
        $data = request()->validate([
            'plan_id' => 'required',
        ]);
        if ($request['sub_end'] != null) $data['sub_end'] = $request['sub_end'];
        else {
            $plan = Plan::find($data['plan_id']);
            $now = Carbon::now();
            $end_date = $now->addDays($plan->period);
            $data['sub_end'] = $end_date->toDateString();
        }
        $store->update($data);
        return back()->with(['success' => __('messages.update_success')]);
    }
    public function get_info(Request $request)
    {
        get_locale();
        request()->validate([
            'store_id' => 'required'
        ]);
        $store = Store::with(['branches', 'plan'])->find($request['store_id']);

        return response()->json($store);
    }
    public function show($id)
    {
        get_locale();
        $store = Store::with(['products', 'product_categories', 'addons', 'edits', 'sauces', 'orders'])->find($id);

        return view('admin.store.show', [
            'store' => $store,
            'products' => $store->products,
            'product_categories' => $store->product_categories,
            'orders' => $store->orders
        ]);
    }
}
