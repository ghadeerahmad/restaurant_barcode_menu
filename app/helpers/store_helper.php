<?php

use App\Models\Order;
use App\Models\Plan;
use App\Models\Setting;
use App\Models\Store;
use App\Models\StoreAdmin;
use App\Models\Table;
use App\Models\Theme;
use App\Models\WorkDay;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

if (!function_exists('get_current_store')) {
    function get_current_store()
    {
        if (Auth::check()) {
            if (session('store_id') != null) return session('store_id');
            $stores = auth()->user()->stores;
            if (count($stores) > 0) {
                session(['store_id' => $stores[0]->store_id]);
                return $stores[0]->store_id;
            }
        }
        return null;
    }
}

if (!function_exists('check_store_admin')) {
    function check_store_admin($store_id)
    {
        $store = StoreAdmin::where('store_id', $store_id)
            ->where('user_id', auth()->user()->id)
            ->first();
        if ($store != null) return true;
        return false;
    }
}

if (!function_exists('store_has_branches')) {
    function store_has_branches()
    {
        $store_id = get_current_store();
        $store = Store::find($store_id);
        if ($store->max_branches > 0) return true;
        return false;
    }
}

if (!function_exists('plan_has_role')) {
    function plan_has_role($role)
    {
        $store_id = get_current_store();
        $store = Store::with(['plan'])->find($store_id);
        $plan_roles = $store->plan->plan_roles;
        //dd($plan_roles);
        foreach ($plan_roles as $r)
            if ($r->role->code == $role) return true;
        return false;
    }
}
if (!function_exists('get_user_stores')) {
    function get_user_stores()
    {
        $stores = auth()->user()->stores;
        if (count($stores) > 0) return $stores;
        return null;
    }
}
if (!function_exists('get_store_name')) {
    function get_store_name($id)
    {
        $store = Store::find($id);
        if ($store != null) return App::isLocale('ar') ? $store->name_ar : $store->name_en;
        return null;
    }
}
if (!function_exists('check_lang_code')) {
    function check_lang_code($lang)
    {
        switch ($lang) {
            case 'ar':
                return 'ar';
            case 'en':
                return 'en';
            default:
                return null;
        }
    }
}
if (!function_exists('check_store_role')) {
    function check_store_role($store_id, $role)
    {
        $store = Store::with(['plan'])->find($store_id);
        $plan_roles = $store->plan->plan_roles;
        //dd($plan_roles);
        foreach ($plan_roles as $r)
            if ($r->role->code == $role) return true;
        return false;
    }
}
if (!function_exists('calc_discount')) {
    function calc_discount($price, $discount, $type)
    {
        switch ($type) {
            case 'AMOUNT':
                return $price - $discount;
            case 'PERCENT':
                $result = $price;
                if ($discount != null && $discount != 0)
                    $result = ($discount * $price) / 100;
                $result = $price - $result;
                if ($result < 0) $result = 0;
                return $result;
            default:
                return $price;
        }
    }
}
if (!function_exists('get_order_status')) {
    function get_order_status($status)
    {
        switch ($status) {
            case 0:
                return __('orders.waiting');
            case 1:
                return __('orders.accepted');
            case 2:
                return __('orders.paid');
            case 3:
                return __('orders.denied');
        }
    }
}
if (!function_exists('get_local_name')) {
    function get_local_name($name_ar, $name_en)
    {
        if ($name_ar !== null && $name_en !== null) {
            return App::isLocale('ar') ? $name_ar : $name_en;
        }
        if (App::isLocale('ar')) {
            if ($name_ar != null)
                return $name_ar;
            else return $name_en;
        }
        if (App::isLocale('en')) {
            if ($name_en != null)
                return $name_en;
            else return $name_ar;
        }
    }
}

if (!function_exists('check_plan_role')) {
    function check_plan_role($plan_id, $role)
    {
        $plan = Plan::with(['plan_roles'])->find($plan_id);
        foreach ($plan->plan_roles as $r)
            if ($r->role->code == $role) return true;
        return false;
    }
}
if (!function_exists('send_whatsapp_message')) {
    function send_whatsapp_message($order)
    {
        $local = App::currentLocale();
        $store_id = $order->store_id;
        $store = Store::find($store_id);
        $message = '';
        $message .= __('orders.place_order');
        $message .= '%0A -------------------------- %0A';
        $message .= '*' . __('orders.order_type') . '* ';
        $type = $local == 'ar' ? 'استلام من الفرع' : 'i will take it my self';
        switch ($order->order_type) {
            case 1:
                $type = $local == 'ar' ? 'توصيل' : 'Delivery';
                break;
            case 2:
                $type = $local == 'ar' ? 'الأكل في المطعم' : 'eat in restaurant';
                break;
        }
        $message .= $type . '%0A';
        $message .= __('orders.order_id') . ': ' . $order->order_unique_id . '%0A';
        if (session('table') != null) {
            $table = Table::find(session('table'));
            if ($table != null)
                $message .= '*' . __('orders.table') . '* : ' . $table->name . ' %0A';
        }
        $products = $order->products;
        $addons = $order->addons;
        $edits = $order->edits;
        $sauces = $order->sauces;
        $sizes = $order->sizes;
        foreach ($products as $value) {
            $message .= $value->quantity . 'X *' . get_local_name($value->product->name_ar, $value->product->name_en) . '* -' . $value->product->price . ' ' . $store->currency->code . '%0A';
            if (count($sizes) > 0) {
                foreach ($sizes as $size)
                    if ($size->product_id == $value->product_id) {
                        $message .= '*' . __('orders.size') . '* : ' . get_local_name($size->size->name_ar, $size->size->name_en) . '%0A';
                        //break;
                    }
            }
            if (count($addons) > 0) {
                foreach ($addons as $addon)
                    if ($addon->product_id == $value->product_id)
                        $message .= '*' . __('orders.addons') . '* :' . '%0A';
                foreach ($addons as $addon) {
                    if ($addon->product_id == $value->product_id) {
                        $message .= get_local_name($addon->addon->name_ar, $addon->addon->name_en) . '-' . $addon->addon->price . ' ' . $store->currency->code . '%0A';
                    }
                }
            }
            if (count($edits) > 0) {
                foreach ($edits as $edit)
                    if ($edit->product_id == $value->product_id)
                        $message .= '*' . __('orders.edits') . '* : %0A';
                foreach ($edits as $edit) {
                    if ($edit->product_id == $value->product_id)
                        $message .= get_local_name($edit->edit->name_ar, $edit->edit->name_en) . ',';
                }
            }
            if (count($sauces) > 0) {
                foreach ($sauces as $sauce)
                    if ($sauce->product_id == $value->product_id)
                        $message .= '*' . __('orders.sauces') . '* : %0A';
                foreach ($sauces as $sauce) {
                    if ($sauce->product_id == $value->product_id)
                        $message .= get_local_name($sauce->sauce->name_ar, $sauce->sauce->name_en) . ',';
                }
            }
        }
        $message .= '%0A -------------------------- %0A';
        $message .= '*' . __('orders.total') . '* : ' . $order->total . ' ' . $store->currency->code . '%0A';
        $message .= '%0A -------------------------- %0A';
        $message .= '*' . __('orders.customer_details') . '* : %0A';
        $message .= '*' . __('orders.customer_name') . '* : ' . $order->customer_name . '%0A';
        $message .= __('orders.customer_phone') . ': ' . $order->customer_phone . '%0A';
        if ($order->latitude != null && $order->longtude != null) $message .= '*' . __('orders.address') . '* : %0A https://www.google.com/maps/place/' . $order->latitude . ',' . $order->longtude;
        if ($order->address != null) $message .= '*' . __('orders.address') . '* : ' . $order->address . '%0A';
        if ($order->comments != null) $message .= '*' . __('orders.comment') . '* : ' . $order->comments . '%0A';
        return $message;
    }
}
if (!function_exists('get_locale')) {
    function get_locale()
    {
        $local = 'en';
        if (session('lang') == null) {
            $lang = Cookie::get('lang');
            if ($lang != null) $local = $lang;
        }
        if (session('lang') == 'ar') $local = 'ar';
        App::setLocale($local);
    }
}
if (!function_exists('get_theme')) {
    function get_theme()
    {
        $store_id = session('store_id');
        if ($store_id != null) {
            $store = Store::find($store_id);
            if ($store->active_theme_id != null) {
                $theme = Theme::find($store->active_theme_id);
                if ($theme != null) return $theme;
            }
        }
        $theme = Theme::where('is_default', 1)->first();
        return $theme;
    }
}
if (!function_exists('calc_work_day')) {
    function calc_work_day()
    {
        $store_id = session('store_id');
        if ($store_id == null) return false;
        $date = date('D');
        $workdays = WorkDay::where('store_id', $store_id)->where('day', $date)->first();
        //dd($workdays);
        if ($workdays == null || $workdays->opening_time == null || $workdays->closing_time == null || $workdays->is_off == 1) return false;

        //dd([time(),strtotime($workdays->closing_time),strtotime($workdays->opening_time)]);
        if (intval(strtotime($workdays->opening_time)) > intval(strtotime($workdays->closing_time)))
            if (intval(time()) < intval(strtotime($workdays->closing_time))) return true;
        if (intval(time()) > intval(strtotime($workdays->opening_time)) && intval(time()) < intval(strtotime($workdays->closing_time)))
            return true;
        return false;
    }
}
if (!function_exists('get_time_string')) {
    function get_time_string($time)
    {
        if ($time == null) return '';
        $local = App::currentLocale();
        $time_string = explode(':', $time);
        $hours = $time_string[0];
        $minutes = $time_string[1];
        $am_pm = $local == 'ar' ? 'صباحاً' : 'AM';
        if ($hours > 12) {
            $am_pm = $local == 'ar' ? 'مساءً' : 'PM';
            $hour = $hours - 12;
            $string = $hour . ':' . $minutes . ' ' . $am_pm;
            return $string;
        } else {
            $string = $hours . ':' . $minutes . ' ' . $am_pm;
            return $string;
        }
    }
}
if (!function_exists('generate_order_id')) {
    function generate_order_id()
    {
        $today = date('Ymd');
        $ids = Order::where('order_unique_id', 'like', $today . '%')->pluck('order_unique_id');
        do {
            $id = $today . rand(10000, 9999);
        } while ($ids->contains($id));
        return $id;
    }
}
