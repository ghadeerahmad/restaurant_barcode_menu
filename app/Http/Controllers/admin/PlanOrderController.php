<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PlanOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlanOrderController extends Controller
{
    public function index()
    {
        get_locale();
        $orders = PlanOrder::with(['user', 'store', 'plan', 'payment_method'])->orderBy('created_at','DESC')->get();
        //dd($orders);
        return view('admin.plans.orders', [
            'orders' => $orders,
        ]);
    }
    public function show($id)
    {
        get_locale();
        $order = PlanOrder::with(['store', 'user', 'plan', 'payment_method'])->find($id);
        return view('admin.plans.show_order', [
            'order' => $order
        ]);
    }
    public function approve($id)
    {
        get_locale();
        $order = PlanOrder::with(['store', 'user', 'plan'])->find($id);
        if ($order == null) return abort(404);
        $order->status = 1;
        $store = $order->store;
        $store->plan_id = $order->plan->id;

        $now = Carbon::now();
        $end_date = $now->addDays($order->plan->period);
        $store->sub_end = $end_date->toDateString();
        if(check_plan_role($order->plan->id,'branches')) $store->max_branches = $order->branche_count;
        $order->save();
        $store->save();
        return back()->with(['success' => __('messages.update_success')]);
    }
    public function decline($id){
        get_locale();
        $order = PlanOrder::find($id);
        $order->status = 2;
        $order->save();
        return back()->with(['success'=>__('messages.update_success')]);
    }
    public function destroy($id){
        get_locale();
        $order = PlanOrder::find($id);
        if($order->image != null)
            Storage::disk('public')->delete($order->image);
        $order->delete();
        return redirect('/admin/plans/orders');
    }
}
