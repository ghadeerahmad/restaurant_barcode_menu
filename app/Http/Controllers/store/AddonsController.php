<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\Currency;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AddonsController extends Controller
{
    public function index($id)
    {
        get_locale();
        $addons = Addon::where('store_id', $id)->get();
        return view();
    }
    public function add()
    {
        get_locale();
        $store = Store::with(['currency'])->find(get_current_store());
        $currency = $store->currency;
        return view('store.addons.add', ['store' => $store, 'currency' => $currency]);
    }
    public function edit($id)
    {
        get_locale();
        $addon = Addon::find($id);
        $store = Store::with(['currency'])->find(get_current_store());
        $currency = $store->currency;
        return view('store.addons.update', [
            'addon' => $addon,
            'currency' => $currency,
            'store'=>$store
        ]);
    }
    public function getAddonsJson($id)
    {
        $addons = Addon::where('store_id', $id)->get();
        return response()->json(['addons' => $addons]);
    }
    public function create(Request $request)
    {
        $store = Store::find(get_current_store());
        request()->validate([
            'name_ar' => 'nullable|max:50',
            'name_en' => 'nullable|max:50',
            'price' => 'required',
        ]);
        $errors = array();
        if ($store->lang_code != null) {
            if ($request['name_' . $store->lang_code] == null) $errors['name'] = __('messages.please_enter_name_' . $store->lang_code);
        } else {
            if ($request['name_ar'] == null || $request['name_en'] == null) $errors['name'] = __('messages.please_enter_name_both');
        }
        if (!empty($errors)) return back()->withErrors($errors);
        $data = array();
        $data['store_id'] = $store->id;
        if ($request['name_ar'] != null) $data['name_ar'] = $request['name_ar'];
        if ($request['name_en'] != null) $data['name_en'] = $request['name_en'];
        $data['price'] = $request['price'];
        $addon = Addon::create($data);
        if ($addon) return back()->with(['success' => __('messages.create_success')]);
    }
    public function update(Request $request, $id)
    {
        $addon = Addon::find($id);
        $store_id = get_current_store();
        if($addon->store_id != $store_id) return abort(403);
        $store = Store::find($store_id);
        request()->validate([
            'name_ar' => 'nullable|max:50',
            'name_en' => 'nullable|max:50',
            'price' => 'required',
        ]);
        $errors = array();
        if ($store->lang_code != null) {
            if ($request['name_' . $store->lang_code] == null) $errors['name'] = __('messages.please_enter_name_' . $store->lang_code);
        } else {
            if ($request['name_ar'] == null || $request['name_en'] == null) $errors['name'] = __('messages.please_enter_name_both');
        }
        if (!empty($errors)) return back()->withErrors($errors);
        $data = array();
        if ($request['name_ar'] != null) $data['name_ar'] = $request['name_ar'];
        if ($request['name_en'] != null) $data['name_en'] = $request['name_en'];
        $data['price'] = $request['price'];
        $addon->update($data);
        return back()->with(['success' => __('messages.update_success')]);
    }
    public function delete($id)
    {
        Addon::where('id', $id)->delete();
        return back()->with(['success' => __('messages.delete_success')]);
    }
}
