<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Models\Size;
use App\Models\Store;
use Illuminate\Http\Request;
use SebastianBergmann\CodeUnit\FunctionUnit;

class SizeController extends Controller
{
    /**
     * create new Size
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name_ar' => 'nullable|max:50',
            'name_en' => 'nullable|max:50',
            'price' => 'required'
        ]);
        $store_id = get_current_store();
        $store = Store::find($store_id);
        if ($store->lang_code != null) {
            if ($request['name_' . $store->lang_code] == null) return back()->withErrors(['name' => __('messages.please_enter_name_' . $store->lang_code)]);
        } else {
            if ($request['name_ar'] == null || $request['name_en'] == null) return back()->withErrors(['name' => __('messages.please_enter_name_both')]);
        }
        $data = [
            'price' => $request['price'],
            'store_id' => $store_id
        ];
        if ($request['name_ar'] != null) $data['name_ar'] = $request['name_ar'];
        if ($request['name_en'] != null) $data['name_en'] = $request['name_en'];
        $size = Size::create($data);
        if ($size) {
            return back()->with(['success' => __('messages.create_success')]);
        }
    }
    /**
     * update size
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $size = Size::find($id);
        $store_id = get_current_store();
        if ($size == null || $size->store_id != $store_id) return abort(404);
        request()->validate([
            'name' => 'required',
            'price' => 'required'
        ]);
        $store_id = get_current_store();
        $data = [
            'name' => $request['name'],
            'price' => $request['price'],
            'store_id' => $store_id
        ];
        $size->update($data);

        return back()->with(['success' => __('messages.create_success')]);
    }
}
