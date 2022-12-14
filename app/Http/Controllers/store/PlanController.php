<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\Plan;
use App\Models\PlanOrder;
use App\Models\Setting;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class PlanController extends Controller
{
    public function __construct()
    {
        get_locale();
    }
    public function index()
    {
        get_locale();
        $plans = Plan::all();
        $store = Store::with(['plan', 'currency'])->find(get_current_store());
        return view('store.plans.index', ['plans' => $plans, 'store' => $store]);
    }
    public function plan_details($id)
    {
        get_locale();
        $plan = Plan::with(['plan_roles', 'currency'])->find($id);
        $store = Store::with(['currency'])->find(get_current_store());
        if ($plan == null) return abort(404);
        return view('store.plans.subscripe', [
            'plan' => $plan,
            'store' => $store
        ]);
    }
    /**
     * open confirm payment page
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function confirm_payment(Request $request)
    {
        request()->validate([
            'plan_id'=>'required',
            'branche_count'=>'nullable'
        ]);
        $id = $request['plan_id'];
        $branche_count = 0;
        if($request['branche_count'] != null) $branche_count = $request['branche_count'];
        get_locale();
        $plan = Plan::find($id);
        if ($plan == null) return abort(404);
        $payment_methods = PaymentMethod::where('is_active', 1)->get();
        $paypal_enabled = Setting::where('key', 'IsPaypalPaymentEnabled')->first();
        $data = [
            'plan' => $plan,
            'payment_methods' => $payment_methods,
            'branche_count'=> $branche_count
        ];
        if ($paypal_enabled->value == 1) $data['paypal'] = $paypal_enabled;
        $cookie = Cookie::forever('order_branche_count',$branche_count);
        $url = url('store/plans/confirm_payment',$plan->id);
        return redirect($url)->withCookie($cookie);
    }
    /**
     * show confirm payment page
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function submit_payment($id){
        get_locale();
        $plan = Plan::find($id);
        if ($plan == null) return abort(404);
        $payment_methods = PaymentMethod::where('is_active', 1)->get();
        $paypal_enabled = Setting::where('key', 'IsPaypalPaymentEnabled')->first();
        $data = [
            'plan' => $plan,
            'payment_methods' => $payment_methods,
        ];
        return view('store.plans.payment_confirm',$data);
    }
    public function method_details($id)
    {
        $method = PaymentMethod::where('is_active', 1)->where('id', $id)->first();
        return response()->json($method);
    }
    public function store_payment(Request $request, $id)
    {
        get_locale();
        request()->validate([
            'method_id' => 'required',
            'payment_number' => 'nullable',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif',
        ]);
        $plan = Plan::find($id);
        $branche_count = 0;
        $count = Cookie::get('order_branche_count');
        if($count != null) $branche_count = intval($count);
        //dd($branche_count);
        $total = $plan->price;
        $cookie = Cookie::forget('order_branche_count');
        if($branche_count != 0) $total = $total* $branche_count;
        if ($plan == null) return abort(404);
        $store_id = get_current_store();
        $order = PlanOrder::where('status', 0)
            ->where('store_id', $store_id)
            ->first();
        if ($order != null) return back()->withErrors(['error' => __('messages.order_already_placed')]);
        $data = [
            'payment_method_id' => $request['method_id'],
            'user_id' => auth()->user()->id,
            'store_id' => $store_id,
            'plan_id' => $id,
            'branche_count'=>$branche_count,
            'total'=>$total
        ];
        if ($request['payment_number'] != null) $data['payment_number'] = $request['payment_number'];
        $order = PlanOrder::create($data);
        if ($order) {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('plan_orders', $fileName, 'public');
                $order->image = $path;
                $order->save();
            }
            return back()->with(['success'=>__('messages.order_placed')])->withCookie($cookie);
        }
    }
    public function paypal_payment($id){
        $plan = Plan::find($id);
        if($plan == null) return abort(404);
    }
}
