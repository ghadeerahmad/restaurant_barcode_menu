<?php

namespace App\Http\Controllers\visitor;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ProductCategory;
use App\Models\Store;
use App\Models\WorkDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class StoreController extends Controller
{
    /**
     * get store
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {

        $store = Store::where('status', 1)
            ->where('id', $id)->first();
        if ($store == null) return abort(404);
        session(['store_id' => $id]);
        $cates = ProductCategory::with(['products'])->where('is_active', 1)
            ->where('store_id', $id)->get();
        $key = Cookie::get('cart-key');
        $cart = null;
        if ($key != null) {
            $cart = Cart::with(['product', 'addons', 'sauces'])->where('key', $key)->get();
        }
        return view('visitors.menu.index', [
            'store' => $store,
            'cates' => $cates,
            'cart' => $cart,
            'locale' => App::currentLocale()
        ]);
    }
    /**
     * show intro page
     */
    public function intro($id)
    {
        // $hours = 20 * 360000000;
        // $minutes = 26 * 60000000;
        // $closing_milliseconds = $hours + $minutes;
        // $h = date('H');

        // dd([$h*360000000,$hours]);
        get_locale();
        $store = Store::find($id);
        if ($store == null) return abort(404);
        session(['store_id' => $id]);
        $work_days = WorkDay::where('store_id', $id)->get();
        return view('visitors.menu.intro', [
            'store' => $store,
            'work_days' => $work_days
        ]);
    }
}
