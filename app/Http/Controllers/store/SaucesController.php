<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Models\Sauce;
use App\Models\Store;
use Illuminate\Http\Request;

class SaucesController extends Controller
{
    public function getSaucesJson(Store $store)
    {
        $sauces = $store->sauces();
        return response()->json(['sauces' => $sauces]);
    }
    public function create(Request $request)
    {
        request()->validate(['price'=>'required']);
        $store = Store::find(get_current_store());
        $data = array();
        $data['store_id'] = get_current_store();
        if ($store->lang_code) {
            if ($request['name_' . $store->lang_code] == null) return back()->withErrors(['name' => __('messages.please_enter_name_' . $store->lang_code)]);
        } else {
            if ($request['name_ar'] == null || $request['name_en'] == null) return back()->withErrors(['name' => __('messages.please_enter_name_both')]);
        }
        if ($request['name_ar'] != null) $data['name_ar'] = $request['name_ar'];
        if ($request['name_en'] != null) $data['name_en'] = $request['name_en'];
        $data['price'] = $request['price'];
        if (Sauce::create($data)) return back()->with(['success' => 'create_success']);
    }
    public function update(Sauce $sauce)
    {
        $data = request()->validate([
            'name' => 'required|max:255'
        ]);
        $sauce->update($data);
        return back()->with(['success' => 'update_success']);
    }
    public function delete($id)
    {
        $sauce = Sauce::find($id);
        $sauce->delete();
        return back()->with(['success' => __('messages.delete_success')]);
    }
}
