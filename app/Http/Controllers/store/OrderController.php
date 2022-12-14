<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderAddon;
use App\Models\OrderEdit;
use App\Models\OrderPayment;
use App\Models\OrderProduct;
use App\Models\OrderSauce;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * get list of orders
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        get_locale();
        $store_id = get_current_store();
        $orders = Order::with(['products', 'addons', 'edits', 'sauces', 'table'])
            ->where('store_id', $store_id)
            ->orderBy('created_at', 'DESC')->get();
        $store = Store::with(['currency'])->find($store_id);
        return view('store.orders.index', ['orders' => $orders, 'store' => $store]);
    }
    /**
     * get order details
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function get_order($id)
    {
        $store_id = get_current_store();
        $order = Order::with(['products', 'addons', 'edits', 'sauces', 'table', 'order_payment'])->find($id);
        if ($order == null || $order->store_id != $store_id) return abort(404);
        $data = array();
        $data['order'] = $order;
        $data['products'] = array();
        $data['addons'] = array();
        $data['edits'] = array();
        $data['sauces'] = array();
        $data['sizes'] = array();
        foreach ($order->products as $value) if ($value->product != null) array_push($data['products'], $value->product);
        foreach ($order->addons as $value) array_push($data['addons'], $value->addon);
        foreach ($order->edits as $value) array_push($data['edits'], $value->edit);
        foreach ($order->sizes as $value) array_push($data['sizes'], $value->size);
        return response()->json($data);
    }
    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function accept($id)
    {
        $order = Order::find($id);
        $store_id = get_current_store();
        if ($order == null || $order->store_id != $store_id) return abort(404);
        $order->status = 1;
        $order->save();
        return back();
    }
    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function set_paid($id)
    {
        $order = Order::find($id);
        $store_id = get_current_store();
        if ($order == null || $order->store_id != $store_id) return abort(404);
        $order->status = 2;
        $order->save();
        return back();
    }
    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function deny($id)
    {
        $order = Order::find($id);
        $store_id = get_current_store();
        if ($order == null || $order->store_id != $store_id) return abort(404);
        $order->status = 3;
        $order->save();
        return back();
    }
    
    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function completed($id)
    {
        $order = Order::find($id);
        $store_id = get_current_store();
        if ($order == null || $order->store_id != $store_id) return abort(404);
        $order->status = 5;
        $order->save();
        return back();
    }
    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function on_delivery($id)
    {
        $order = Order::find($id);
        $store_id = get_current_store();
        if ($order == null || $order->store_id != $store_id) return abort(404);
        $order->status = 4;
        $order->save();
        return back();
    }
    /**
     * @param int $id
     * @param \illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        $store_id = get_current_store();
        if ($order == null || $order->store_id != $store_id) return abort(404);
        OrderAddon::where('order_id', $id)->delete();
        OrderProduct::where('order_id', $id)->delete();
        OrderEdit::where('order_id', $id)->delete();
        OrderSauce::where('order_id', $id)->delete();
        $order_payment = OrderPayment::where('order_id', $id)->get();
        foreach ($order_payment as $payment) {
            if ($payment->image != null)
                Storage::disk('public')->delete($payment->image);
        }
        OrderPayment::where('order_id', $id)->delete();
        $order->delete();
        return back()->with(['success' => __('messages.delete_success')]);
    }
}
