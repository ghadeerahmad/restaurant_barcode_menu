<?php

namespace App\Http\Controllers\visitor;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartAddon;
use App\Models\CartEdit;
use App\Models\CartSauce;
use App\Models\CartSize;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderAddon;
use App\Models\OrderEdit;
use App\Models\OrderPayment;
use App\Models\OrderProduct;
use App\Models\OrderSauce;
use App\Models\OrderSize;
use App\Models\Store;
use App\Models\StorePaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        if (Auth::check()) {
        }
    }

    /**
     * Show the form for creating a new resource.
     * @param Store $store
     * @return \Illuminate\Http\Response
     */
    public function create(Store $store)
    {
        if (!calc_work_day()) return abort(404);
        get_locale();
        $local = App::currentLocale();
        if ($store->status != 1) return redirect('cart');
        $payment_methods = StorePaymentMethod::where('store_id', $store->id)->get();

        $key = Cookie::get('cart-key');
        $cart = Cart::with(['product', 'addons', 'edits', 'sauces', 'sizes'])->where('key', $key)->where('store_id', $store->id)->get();
        if (Auth::check()) {
            if (count($cart) == 0) $cart = Cart::with(['product', 'addons', 'edits', 'sauces', 'sizes'])->where('store_id', $store->id)
                ->where('user_id', auth()->user()->id)
                ->orWhere('key', $key)
                ->get();
            if (count($cart) == 0) return redirect('cart');
        } else {
            if (count($cart) == 0) return redirect('cart');
        }
        //dd($cart[0]->addons[0]->addon);
        return view('visitors.orders.create', [
            'store' => $store,
            'items' => $cart,
            'payment_methods' => $payment_methods,
            'settings' => $store->setting,

        ]);
    }

    /**
     * Show the form for creating a new table order.
     * @param Store $store
     * @return \Illuminate\Http\Response
     */
    public function table_create(Store $store)
    {
        if (session('table') == null) return abort(404);
        get_locale();
        if ($store->status != 1) return redirect('cart');
        $payment_methods = StorePaymentMethod::where('store_id', $store->id)->get();
        $key = Cookie::get('cart-key');
        $cart = Cart::with(['product', 'addons', 'edits', 'sauces', 'sizes'])->where('key', $key)->where('store_id', $store->id)->get();
        if (Auth::check()) {
            if (count($cart) == 0) $cart = Cart::with(['product', 'addons', 'edits', 'sauces', 'sizes'])->where('store_id', $store->id)
                ->where('user_id', auth()->user()->id)
                ->orWhere('key', $key)
                ->get();
            if (count($cart) == 0) return redirect('cart');
        } else {
            if (count($cart) == 0) return redirect('cart');
        }
        //dd($cart[0]->addons[0]->addon);
        return view('visitors.tables.create_order', [
            'store' => $store,
            'items' => $cart,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        get_locale();
        request()->validate([
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'payment_method' => 'required',
            'delivery_type' => 'required',
        ]);
        if ($request['delivery_type'] == 1)
            if (($request['latitude'] == null || $request['longtude'] == null) && $request['address'] == null)
                return back()->withErrors(['error' => __('messages.please_select_location')]);
        $store = Store::find($id);
        if ($store == null) return abort(404);
        $key = Cookie::get('cart-key');
        $cart = Cart::with(['product', 'addons', 'edits', 'sauces', 'sizes'])->where('key', $key)->where('store_id', $id)->get();
        if (Auth::check()) {
            if ($cart == null) $cart = Cart::with(['product', 'addons', 'edits', 'sauces', 'sizes'])
                ->where('store_id', $store->id)
                ->where('user_id', auth()->user()->id)
                ->orWhere('key', $key)->get();
            if ($cart == null) return redirect('cart');
        } else {
            if ($cart == null) return redirect('cart');
        }
        if (count($cart) == 0) return back();
        $key = Cookie::get('cart-key');
        if ($key == null) {
            $key = Str::random(30);
            Cookie::forever('cart-key', $key);
        }
        $data = [
            'customer_name' => $request['customer_name'],
            'customer_phone' => $request['customer_phone'],
            'store_id' => $id,
            'user_key' => $key,
            'order_type' => $request['delivery_type']
        ];
        if ($request['comments'] != null) $data['comments'] = $request['comments'];
        if (Auth::check()) $data['user_id'] = auth()->user()->id;
        if ($request['address'] != null) $data['address'] = $request['address'];
        if ($request['latitude'] != null && $request['longtude'] != null) {
            $data['latitude'] = $request['latitude'];
            $data['longtude'] = $request['longtude'];
        }
        $tax = 0;
        $delivery_charge = 0;
        $total = 0;
        $disount = 0;
        foreach ($cart as $item) {
            $price = $item->product->price;
            if ($item->product->discount != null) {
                $price = calc_discount($price, $item->product->discount, $item->product->discount_type);
            }
            $total += $price * $item->quantity;
            foreach ($item->addons as $addon)
                $total += $addon->addon->price * $item->quantity;
            foreach ($item->sauces as $sauce)
                $total += $sauce->sauce->price * $item->quantity;
            foreach ($item->sizes as $size)
                $total += $size->size->price * $item->quantity;
        }
        $data['tax'] = $store->tax;

        if ($request['coupon_code'] != null) {
            $coupon = Coupon::where('code', $request['coupon_code'])
                ->where('store_id', $id)
                ->where('is_active', 1)
                ->first();
            if ($coupon == null) return back()->withErrors(['errors' => __('messages.coupon_not_found')]);
            $data['coupon_code'] = $request['coupon_code'];
            switch ($coupon->type) {
                case 'AMOUNT':
                    $total = $total - $coupon->discount;
                    if ($total < 0) $total = 0;
                    break;
                case 'PERCENT':
                    $res = ($total * $coupon->discount) / 100;
                    $total = $total - $res;
                    break;
            }
        }
        $delivery_enabled = 0;
        if (check_store_role($id, 'delivery') && $request['delivery_type'] == 1) {
            $delivery_enabled = 1;
            $total += $store->delivery_fees;
            $data['delivery_charge'] = $store->delivery_fees;
        }
        $data['is_delivery_enabled'] = $delivery_enabled;
        if ($store->tax != null) {
            switch ($store->tax_type) {
                case 'PERCENT':
                    $total += $total * $store->tax / 100;
                    break;
                case 'AMOUNT':
                    $total += $store->tax;
                    break;
            }
        }
        $data['total'] = $total;
        $unique_id = random_int(100000, 999999999);
        while (true) {
            $order = Order::where('order_unique_id', $unique_id)->first();
            if ($order == null) break;
            $unique_id = random_int(0, 30);
        }
        $data['order_unique_id'] = $unique_id;
        if ($request['payment_method'] == "CASH") $data['payment_type'] = 'CASH';

        $order = Order::create($data);
        if ($order) {

            $order_products = [];
            foreach ($cart as $item)
                array_push($order_products, ['order_id' => $order->id, 'product_id' => $item->product->id, 'quantity' => $item->quantity, 'size' => $item['size']]);
            OrderProduct::insert($order_products);
            if ($request['payment_method'] != 'CASH') {
                $payment_method = StorePaymentMethod::where('store_id', $id)
                    ->where('id', $request['payment_method'])->first();
                if ($payment_method == null) return back()->withErrors(['errors' => __('messages.payment_method_not_found')]);
                $payment_details = [
                    'order_id' => $order->id,
                    'payment_method' => $payment_method->title_en
                ];
                if ($request['payment_number'] != null) $payment_details['payment_number'] = $request['payment_number'];
                if ($request['note'] != null) $payment_details['notes'] = $request['note'];
                $payment = OrderPayment::create($payment_details);
                if ($payment) {
                    if ($request->hasFile('image')) {
                        $file = $request->file('image');
                        $file_name = time() . '.' . $file->getClientOriginalExtension();
                        $path = $file->storeAs('orders', $file_name, 'public');
                        $payment->image = $path;
                        $payment->save();
                    }
                }
            }
            $order_addons = array();
            $order_edits = array();
            $order_sauces = array();
            $order_sizes = array();
            foreach ($cart as $item) {

                if ($item->addons != null)
                    foreach ($item->addons as $addon)
                        array_push($order_addons, [
                            'order_id' => $order->id,
                            'product_id' => $item->product->id,
                            'addon_id' => $addon->addon->id,
                        ]);
                if ($item->edits != null)
                    foreach ($item->edits as $edit)
                        array_push($order_edits, [

                            'order_id' => $order->id,
                            'product_id' => $item->product->id,
                            'edit_id' => $edit->edit->id,
                        ]);
                if ($item->sacues != null)
                    foreach ($item->sacues as $sauce)
                        array_push($order_sacues, [

                            'order_id' => $order->id,
                            'product_id' => $item->product->id,
                            'sauce_id' => $sauce->sauce->id,
                        ]);
                if ($item->sizes != null)
                    foreach ($item->sizes as $sauce)
                        array_push($order_sizes, [

                            'order_id' => $order->id,
                            'product_id' => $item->product->id,
                            'size_id' => $size->size->id,
                        ]);
            }
            if (!empty($order_addons))
                OrderAddon::insert($order_addons);
            if (!empty($order_edits)) OrderEdit::insert($order_edits);
            if (!empty($order_sauces)) OrderSauce::insert($order_sauces);
            if (!empty($order_sizes)) OrderSize::insert($order_sizes);
            foreach ($cart as $item) {
                CartAddon::where('cart_id', $item->id)->delete();
                CartEdit::where('cart_id', $item->id)->delete();
                CartSauce::where('cart_id', $item->id)->delete();
                CartSize::where('cart_id', $item->id)->delete();
            }
            if (Auth::check()) {
                if ($cart == null) $cart = Cart::with(['product'])
                    ->where('store_id', $store->id)
                    ->where('user_id', auth()->user()->id)
                    ->orWhere('key', $key)->delete();
            } else {
                $cart = Cart::where('key', $key)->where('store_id', $id)->delete();
            }
            if ($store->phone != null) {
                $message = send_whatsapp_message($order);
                return redirect()->away('https://api.whatsapp.com/send?phone=' . $store->country_code->code . $store->phone . '&text=' . $message);
            }
            return redirect('store/menu/' . $id);
        }
    }
    /**
     * store table order
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function store_table_order(Request $request, $id)
    {
        get_locale();
        request()->validate([
            'customer_name' => 'required',
            'customer_phone' => 'required',
        ]);
        if (session('table') == null) return abort(404);
        $table_id = session('table');
        $store = Store::find($id);
        if ($store == null) return abort(404);
        $key = Cookie::get('cart-key');
        $cart = Cart::with(['product', 'addons', 'edits', 'sauces', 'sizes'])->where('key', $key)->where('store_id', $id)->get();
        if (Auth::check()) {
            if ($cart == null) $cart = Cart::with(['product', 'addons', 'edits', 'sauces', 'sizes'])
                ->where('store_id', $store->id)
                ->where('user_id', auth()->user()->id)
                ->orWhere('key', $key)->get();
            if ($cart == null) return redirect('cart');
        } else {
            if ($cart == null) return redirect('cart');
        }
        if (count($cart) == 0) return back();
        $key = Cookie::get('cart-key');
        if ($key == null) {
            $key = Str::random(30);
            Cookie::forever('cart-key', $key);
        }
        $data = [
            'customer_name' => $request['customer_name'],
            'customer_phone' => $request['customer_phone'],
            'store_id' => $id,
            'table_id' => $table_id,
            'payment_type' => 'CASH',
            'user_key' => $key,
            'order_type' => 2
        ];
        if ($request['comments'] != null) $data['comments'] = $request['comments'];
        if (Auth::check()) $data['user_id'] = auth()->user()->id;
        $tax = 0;
        $delivery_charge = 0;
        $total = 0;
        $disount = 0;
        foreach ($cart as $item) {

            $price = $item->product->price;
            if ($item->product->discount != null) {
                $price = calc_discount($price, $item->product->discount, $item->product->discount_type);
            }
            $total += $price * $item->quantity;
            foreach ($item->addons as $addon)
                $total += $addon->addon->price * $item->quantity;
            foreach ($item->sauces as $sauce)
                $total += $sauce->sauce->price * $item->quantity;
            foreach ($item->sizes as $size)
                $total += $size->size->price * $item->quantity;
        }
        $data['tax'] = $store->tax;
        if ($store->tax != 0) {
            switch ($store->tax_type) {
                case 'PERCENT':
                    $total += ($total * $store->tax) / 100;
                    break;
                case 'AMOUNT':
                    $total += $store->tax;
                    break;
            }
        }
        if ($request['coupon_code'] != null) {
            $coupon = Coupon::where('code', $request['coupon_code'])
                ->where('store_id', $id)
                ->where('is_active', 1)
                ->first();
            if ($coupon == null) return back()->withErrors(['errors' => __('messages.coupon_not_found')]);
            $data['coupon_code'] = $request['coupon_code'];
            switch ($coupon->type) {
                case 'AMOUNT':
                    $total = $total - $coupon->discount;
                    if ($total < 0) $total = 0;
                    break;
                case 'PERCENT':
                    $res = ($total * $coupon->discount) / 100;
                    $total = $total - $res;
                    break;
            }
        }
        $data['is_delivery_enabled'] = 0;
        // $waiter_call_enabled = 0;
        // if($request['waiter_call'] == 1)  $waiter_call_enabled=1;
        // $data['call_waiter_enabled'] = $waiter_call_enabled;
        $total += $tax;
        $data['total'] = $total;
        $unique_id = random_int(100000, 999999999);
        while (true) {
            $order = Order::where('order_unique_id', $unique_id)->first();
            if ($order == null) break;
            $unique_id = random_int(0, 30);
        }
        $data['order_unique_id'] = $unique_id;

        $order = Order::create($data);
        if ($order) {
            $order_products = [];
            foreach ($cart as $item)
                array_push($order_products, ['order_id' => $order->id, 'product_id' => $item->product->id, 'quantity' => $item->quantity]);
            OrderProduct::insert($order_products);
            if ($request['payment_method'] != null && $request['payment_method'] != 'CASH') {
                $payment_method = StorePaymentMethod::where('store_id', $id)
                    ->where('id', $request['payment_method'])->first();
                if ($payment_method == null) return back()->withErrors(['errors' => __('messages.payment_method_not_found')]);
                $payment_details = [
                    'order_id' => $order->id,
                    'payment_method' => $payment_method->title_en
                ];
                if ($request['payment_number'] != null) $payment_details['payment_number'] = $request['payment_number'];
                if ($request['note'] != null) $payment_details['notes'] = $request['note'];
                $payment = OrderPayment::create($payment_details);
                if ($payment) {
                    if ($request->hasFile('image')) {
                        $file = $request->file('image');
                        $file_name = time() . '.' . $file->getClientOriginalExtension();
                        $path = $file->storeAs('orders', $file_name, 'public');
                        $payment->image = $path;
                        $payment->save();
                    }
                }
            }
            $order_addons = array();
            $order_edits = array();
            $order_sauces = array();
            $order_sizes = array();
            foreach ($cart as $item) {

                if ($item->addons != null)
                    foreach ($item->addons as $addon)
                        array_push($order_addons, [
                            'order_id' => $order->id,
                            'product_id' => $item->product->id,
                            'addon_id' => $addon->addon->id,
                        ]);
                if ($item->edits != null)
                    foreach ($item->edits as $edit)
                        array_push($order_edits, [

                            'order_id' => $order->id,
                            'product_id' => $item->product->id,
                            'edit_id' => $edit->edit->id,
                        ]);
                if ($item->sacues != null)
                    foreach ($item->sacues as $sauce)
                        array_push($order_sacues, [

                            'order_id' => $order->id,
                            'product_id' => $item->product->id,
                            'sauce_id' => $sauce->sauce->id,
                        ]);
                if ($item->sizes != null)
                    foreach ($item->sizes as $sauce)
                        array_push($order_sizes, [

                            'order_id' => $order->id,
                            'product_id' => $item->product->id,
                            'size_id' => $size->size->id,
                        ]);
            }
            if (!empty($order_addons))
                OrderAddon::insert($order_addons);
            if (!empty($order_edits)) OrderEdit::insert($order_edits);
            if (!empty($order_sauces)) OrderSauce::insert($order_sauces);
            if (!empty($order_sizes)) OrderSize::insert($order_sizes);
            foreach ($cart as $item) {
                CartAddon::where('cart_id', $item->id)->delete();
                CartEdit::where('cart_id', $item->id)->delete();
                CartSauce::where('cart_id', $item->id)->delete();
                CartSize::where('cart_id',$item->id)->delete();
            }
            if (Auth::check()) {
                if ($cart == null) $cart = Cart::with(['product'])
                    ->where('store_id', $store->id)
                    ->where('user_id', auth()->user()->id)
                    ->orWhere('key', $key)->delete();
            } else {
                $cart = Cart::where('key', $key)->where('store_id', $id)->delete();
            }

            if ($store->phone != null) {
                $message = send_whatsapp_message($order);
                return redirect()->away('https://api.whatsapp.com/send?phone=' . $store->country_code->code.$store->phone . '&text=' . $message);
            }
            //return redirect('cart');
            return redirect('store/' . $id . '/table/' . $table_id);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /**
     * check coupon validity
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function check_coupon(Request $request)
    {
        get_locale();
        request()->validate([
            'code' => 'required',
            'store_id' => 'required'
        ]);
        $code = $request['code'];
        $coupon = Coupon::where('code', $code)
            ->where('is_active', 1)
            ->where('store_id', $request['store_id'])
            ->first();
        if ($coupon != null) return response()->json(['message' => 'success', 'value' => $coupon->discount, 'type' => $coupon->type]);
        return response()->json(['message' => 'faild']);
    }
    /**
     * get payment information
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function get_payment_info(Request $request)
    {
        get_locale();
        request()->validate([
            'store_id' => 'required',
            'payment_method' => 'required'
        ]);
        $payment_method = StorePaymentMethod::where('store_id', $request['store_id'])
            ->where('id', $request['payment_method'])->first();
        if ($payment_method == null) return response()->json(['message' => 'not found'], 404);
        return response()->json($payment_method);
    }
}
