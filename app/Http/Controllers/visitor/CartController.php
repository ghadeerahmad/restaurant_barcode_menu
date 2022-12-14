<?php

namespace App\Http\Controllers\visitor;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartAddon;
use App\Models\CartEdit;
use App\Models\CartSauce;
use App\Models\CartSize;
use App\Models\Product;
use App\Models\Store;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * get user cart
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (session('store_id') == null) return abort(404);
        $id = session('store_id');
        get_locale();
        $data = array();
        if (Auth::check()) {
            $key = Cookie::get('cart-key');
            if ($key != null) {
                $cart = Cart::with(['product', 'store', 'addons', 'edits', 'sauces'])->where('store_id', $id)
                    ->where('key', $key)
                    ->orWhere('user_id', auth()->user()->id)->get();
                $data = $cart;
            } else {
                $cart = Cart::with(['product', 'store', 'addons', 'edits', 'sauces'])->where('store_id', $id)
                    ->where('user_id', auth()->user()->id)->get();
                $data = $cart;
            }
        } else {
            $key = Cookie::get('cart-key');
            if ($key != null) {
                $cart = Cart::with(['product', 'store', 'addons', 'edits', 'sauces'])->where('store_id', $id)
                    ->where('key', $key)->get();
                $data = $cart;
            }
        }
        //dd($data);
        return view('visitors.cart.index', [
            'cart' => $data,
            'locale' => App::currentLocale()
        ]);
    }
    /**
     * get table cart
     * @return \Illuminate\Http\Response
     */
    public function table_cart()
    {
        get_locale();
        if (session('table') == null) return abort(404);
        $table_id = session('table');
        $table = Table::find($table_id);
        if ($table == null) return abort(404);
        $locale = 'ar';
        if (App::isLocale('ar')) $locale = 'ar';
        $data = array();
        if (Auth::check()) {
            $key = Cookie::get('cart-key');
            if ($key != null) {
                $cart = Cart::with(['product', 'store'])
                    ->where('table_id', $table_id)
                    ->where('key', $key)
                    ->orWhere('user_id', auth()->user()->id)->get()->groupBy('store_id');
                $data = $cart;
            } else {
                $cart = Cart::with(['product', 'store'])
                    ->where('table_id', $table_id)
                    ->where('user_id', auth()->user()->id)->get()->groupBy('store_id');
                $data = $cart;
            }
        } else {
            $key = Cookie::get('cart-key');
            if ($key != null) {
                $cart = Cart::with(['product', 'store'])
                    ->where('table_id', $table_id)
                    ->where('key', $key)->get()->groupBy('store_id');
                $data = $cart;
            }
        }
        //dd($data);
        return view('visitors.tables.cart', [
            'cart' => $data,
            'locale' => $locale,
            'table' => $table
        ]);
    }
    /**
     * store an item into cart
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        get_locale();
        request()->validate([
            'product_id' => 'required',
            'store_id' => 'required',
            'quantity' => 'required',
            'addons' => 'nullable|array',
            'edits' => 'nullable|array',
            'sauces' => 'nullable|array',
            'sizes' => 'nullable|array'
        ]);

        $product = Product::where('store_id', $request['store_id'])
            ->where('id', $request['product_id'])->first();
        if ($product == null) return response()->json([], 404);
        $data = [
            'store_id' => $request['store_id'],
            'product_id' => $request['product_id'],
            'quantity' => $request['quantity'],
        ];
        if (1 != 1) {
            // $data['user_id'] = auth()->user()->id;
            // $cart = Cart::create($data);
            // if ($cart) {
            //     $addons = array();
            //     $edits = array();
            //     $sauces = array();
            //     if ($request['addons'] != null)
            //         foreach ($request['addons'] as $item)
            //             array_push($addons, ['cart_id' => $cart->id, 'product_id' => $request['product_id'], 'addon_id' => $item]);
            //     if ($request['edits'] != null)
            //         foreach ($request['edits'] as $item)
            //             array_push($edits, ['cart_id' => $cart->id, 'product_id' => $request['product_id'], 'edit_id' => $item]);
            //     if ($request['sauces'] != null)
            //         foreach ($request['sauces'] as $item)
            //             array_push($sauces, ['cart_id' => $cart->id, 'product_id' => $request['product_id'], 'sauce_id' => $item]);
            //     if (!empty($addons)) CartAddon::insert($addons);
            //     if (!empty($edits)) CartEdit::insert($edits);
            //     if (!empty($sauces)) CartSauce::insert($sauces);
            //     return response()->json(['message' => __('messages.add_success')]);
            // }
        } else {
            $key = Cookie::get('cart-key');
            if ($key == null) {
                $key = Str::random(30);
                $r = true;
                while (true) {
                    $check = Cart::where('key', $key)->first();
                    if ($check == null) {
                        break;
                    }
                    $key = Str::random(30);
                }
                $data['key'] = $key;
                $cookie = Cookie::forever('cart-key', $key);
                $cart = Cart::create($data);
                if ($cart) {
                    $addons = array();
                    $edits = array();
                    $sauces = array();
                    $sizes = array();
                    if ($request['addons'] != null)
                        foreach ($request['addons'] as $item)
                            array_push($addons, ['cart_id' => $cart->id, 'product_id' => $request['product_id'], 'addon_id' => $item]);
                    if ($request['edits'] != null)
                        foreach ($request['edits'] as $item)
                            array_push($edits, ['cart_id' => $cart->id, 'product_id' => $request['product_id'], 'edit_id' => $item]);
                    if ($request['sauces'] != null)
                        foreach ($request['sauces'] as $item)
                            array_push($sauces, ['cart_id' => $cart->id, 'product_id' => $request['product_id'], 'sauce_id' => $item]);
                    if ($request['sizes'] != null)
                        foreach ($request['sizes'] as $item)
                            array_push($sizes, ['cart_id' => $cart->id, 'product_id' => $request['product_id'], 'size_id' => $item]);
                    if (!empty($addons)) CartAddon::insert($addons);
                    if (!empty($edits)) CartEdit::insert($edits);
                    if (!empty($sauces)) CartSauce::insert($sauces);
                    if (!empty($sizes)) CartSize::insert($sizes);
                    return response()->json(['message' => __('messages.add_success')])->withCookie($cookie);
                }
            } else {

                $check = Cart::where('product_id', $request['product_id'])->where('key', $key)->first();
                if ($check != null) {
                    $check->quantity += 1;
                    $check->save();
                    return response()->json(['message' => __('messages.add_success')]);
                }
                $data['key'] = $key;
                $cart = Cart::create($data);
                if ($cart) {
                    $addons = array();
                    $edits = array();
                    $sauces = array();
                    $sizes = array();
                    if ($request['addons'] != null)
                        foreach ($request['addons'] as $item)
                            array_push($addons, ['cart_id' => $cart->id, 'product_id' => $request['product_id'], 'addon_id' => $item]);
                    if ($request['edits'] != null)
                        foreach ($request['edits'] as $item)
                            array_push($edits, ['cart_id' => $cart->id, 'product_id' => $request['product_id'], 'edit_id' => $item]);
                    if ($request['sauces'] != null)
                        foreach ($request['sauces'] as $item)
                            array_push($sauces, ['cart_id' => $cart->id, 'product_id' => $request['product_id'], 'sauce_id' => $item]);
                    if ($request['sizes'] != null)
                        foreach ($request['sizes'] as $item)
                            array_push($sizes, ['cart_id' => $cart->id, 'product_id' => $request['product_id'], 'size_id' => $item]);
                    if (!empty($addons)) CartAddon::insert($addons);
                    if (!empty($edits)) CartEdit::insert($edits);
                    if (!empty($sauces)) CartSauce::insert($sauces);
                    if (!empty($sizes)) CartSize::insert($sizes);
                    return response()->json(['message' => __('messages.add_success')]);
                }
            }
        }
    }
    /**
     * store an item into cart
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store_table(Request $request)
    {
        get_locale();
        request()->validate([
            'product_id' => 'required',
            'store_id' => 'required',
            'quantity' => 'required',
            'addons' => 'nullable|array',
            'edits' => 'nullable|array',
            'sauces' => 'nullable|array',
            'sizes' => 'nullable|array'
        ]);
        if (session('table') == null) return abort(404);
        $table = Table::find(session('table'));
        if ($table == null) return abort(404);
        if ($table->store_id != $request['store_id']) return abort(404);
        $product = Product::where('store_id', $request['store_id'])
            ->where('id', $request['product_id'])->first();
        if ($product == null) return response()->json([], 404);
        $data = [
            'store_id' => $request['store_id'],
            'product_id' => $request['product_id'],
            'quantity' => $request['quantity'],
            'table_id' => $table->id
        ];
        if (Auth::check()) {
            $data['user_id'] = auth()->user()->id;
            $cart = Cart::create($data);
            if ($cart) {
                $addons = array();
                $edits = array();
                $sauces = array();
                $sizes = array();
                if ($request['addons'] != null)
                    foreach ($request['addons'] as $item)
                        array_push($addons, ['cart_id' => $cart->id, 'product_id' => $request['product_id'], 'addon_id' => $item]);
                if ($request['edits'] != null)
                    foreach ($request['edits'] as $item)
                        array_push($edits, ['cart_id' => $cart->id, 'product_id' => $request['product_id'], 'edit_id' => $item]);
                if ($request['sauces'] != null)
                    foreach ($request['sauces'] as $item)
                        array_push($sauces, ['cart_id' => $cart->id, 'product_id' => $request['product_id'], 'sauce_id' => $item]);
                if ($request['sizes'] != null)
                    foreach ($request['sizes'] as $item)
                        array_push($sizes, ['cart_id' => $cart->id, 'product_id' => $request['product_id'], 'size_id' => $item]);
                if (!empty($addons)) CartAddon::insert($addons);
                if (!empty($edits)) CartEdit::insert($edits);
                if (!empty($sauces)) CartSauce::insert($sauces);
                if (!empty($sizes)) CartSize::insert($sizes);
                return response()->json(['message' => __('messages.add_success')]);
            }
        } else {
            $key = Cookie::get('cart-key');
            if ($key == null) {
                $key = Str::random(30);
                $r = true;
                while (true) {
                    $check = Cart::where('key', $key)->first();
                    if ($check == null) {
                        break;
                    }
                    $key = Str::random(30);
                }
                $data['key'] = $key;
                $cookie = Cookie::forever('cart-key', $key);
                $cart = Cart::create($data);
                if ($cart) {
                    $addons = array();
                    $edits = array();
                    $sauces = array();
                    $sizes = array();
                    if ($request['addons'] != null)
                        foreach ($request['addons'] as $item)
                            array_push($addons, ['cart_id' => $cart->id, 'product_id' => $request['product_id'], 'addon_id' => $item]);
                    if ($request['edits'] != null)
                        foreach ($request['edits'] as $item)
                            array_push($edits, ['cart_id' => $cart->id, 'product_id' => $request['product_id'], 'edit_id' => $item]);
                    if ($request['sauces'] != null)
                        foreach ($request['sauces'] as $item)
                            array_push($sauces, ['cart_id' => $cart->id, 'product_id' => $request['product_id'], 'sauce_id' => $item]);
                    if ($request['sizes'] != null)
                        foreach ($request['sizes'] as $item)
                            array_push($sizes, ['cart_id' => $cart->id, 'product_id' => $request['product_id'], 'size_id' => $item]);
                    if (!empty($addons)) CartAddon::insert($addons);
                    if (!empty($edits)) CartEdit::insert($edits);
                    if (!empty($sauces)) CartSauce::insert($sauces);
                    if (!empty($sizes)) CartSize::insert($sizes);
                    return response()->json(['message' => __('messages.add_success')])->withCookie($cookie);
                }
            } else {
                $data['key'] = $key;
                $cart = Cart::create($data);
                if ($cart) {
                    $addons = array();
                    $edits = array();
                    $sauces = array();
                    if ($request['addons'] != null)
                        foreach ($request['addons'] as $item)
                            array_push($addons, ['cart_id' => $cart->id, 'product_id' => $request['product_id'], 'addon_id' => $item]);
                    if ($request['edits'] != null)
                        foreach ($request['edits'] as $item)
                            array_push($edits, ['cart_id' => $cart->id, 'product_id' => $request['product_id'], 'edit_id' => $item]);
                    if ($request['sauces'] != null)
                        foreach ($request['sauces'] as $item)
                            array_push($sauces, ['cart_id' => $cart->id, 'product_id' => $request['product_id'], 'sauce_id' => $item]);
                    if (!empty($addons)) CartAddon::insert($addons);
                    if (!empty($edits)) CartEdit::insert($edits);
                    if (!empty($sauces)) CartSauce::insert($sauces);
                    return response()->json(['message' => __('messages.add_success')]);
                }
            }
        }
    }
    /**
     * delte an item from cart
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        get_locale();
        $item = Cart::find($id);
        if($item == null) return back();
        if (Auth::check()) {
            $key = Cookie::get('cart-key');
            $result = false;
            if (auth()->user()->id == $item->user_id) $result = true;
            if ($item->key == $key) $result = true;
            if (!$result) return abort(404);
        } else {
            $key = Cookie::get('cart-key');
            if ($key != $item->key) return abort(404);
        }
        CartAddon::where('cart_id', $item->id)->delete();
        CartEdit::where('cart_id', $item->id)->delete();
        CartSauce::where('cart_id', $item->id)->delete();
        CartSize::where('cart_id',$item->id)->delete();
        $item->delete();
        return back()->with(['success' => __('messages.delete_success')]);
    }
    /**
     * update quantity
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update_quantity(Request $request, $id)
    {
        request()->validate([
            'quantity' => 'required'
        ]);
        $key = Cookie::get('cart-key');
        $user_id = null;
        if (Auth::check()) $user_id == auth()->user()->id;
        $cart = Cart::where('id', $id)->where('key', $key)->first();
        if ($cart != null) {
            $cart->quantity = $request['quantity'];
            $cart->update();
        }
        return response()->json(['message' => __('messages.update_success')]);
    }
}
