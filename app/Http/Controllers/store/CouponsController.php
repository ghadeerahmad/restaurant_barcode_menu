<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Store;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        get_locale();
        $coupons = Coupon::where('store_id', get_current_store())->get();
        return view('store.coupons.index', ['coupons' => $coupons]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        get_locale();
        $store = Store::find(get_current_store());
        return view('store.coupons.add', ['store' => $store]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(
            [
                'name_ar' => 'nullable|max:50',
                'name_en' => 'nullable|max:50',
                'description_ar' => 'nullable:255',
                'description_en' => 'nullable:255',
                'code' => 'required',
                'discount' => 'required',
                'discount_type' => 'required'
            ]
        );
        $errors = array();
        $store = Store::find(get_current_store());
        if ($store->lang_code != null) {
            $lang = $store->lang_code;
            if ($request['name_' . $lang] == null) $errors['name'] = __('messages.please_enter_name_' . $lang);
            if ($request['description_' . $lang] == null) $errors['description'] = __('messages.please_enter_description_' . $lang);
        } else {
            if ($request['name_ar'] == null || $request['name_en'] == null) $errors['name'] = __('messages.please_enter_name_both');
            if ($request['description_ar'] == null || $request['description_en'] == null) $errors['description'] = __('messages.please_enter_description_both');
        }
        if (!empty($errors)) return back()->withErrors($errors);
        $data = array();
        $request['is_active'] != null ? $data['is_active'] = 1 : $data['is_active'] = 0;
        $data['store_id'] = $store->id;
        if ($request['name_ar'] != null) $data['name_ar'] = $request['name_ar'];
        if ($request['name_en'] != null) $data['name_en'] = $request['name_en'];
        if ($request['description_ar'] != null) $data['description_ar'] = $request['description_ar'];
        if ($request['description_en'] != null) $data['description_en'] = $request['description_en'];
        $data['discount'] = $request['discount'];
        $data['type'] = $request['discount_type'];
        $data['code'] = $request['code'];
        if (Coupon::create($data)) {
            return redirect('store/coupons');
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
        get_locale();
        $coupon = Coupon::find($id);
        $store_id = get_current_store();
        if ($coupon->store_id != $store_id) return abort(403);
        $store = Store::find($store_id);
        return view('store.coupons.update', ['coupon' => $coupon, 'store' => $store]);
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
        $coupon = Coupon::find($id);
        $store_id = get_current_store();
        if ($coupon->store_id != $store_id) return abort(403);
        request()->validate(
            [
                'name_ar' => 'nullable|max:50',
                'name_en' => 'nullable|max:50',
                'description_ar' => 'nullable:255',
                'description_en' => 'nullable:255',
                'code' => 'required',
                'discount' => 'required',
                'discount_type' => 'required'
            ]
        );
        $errors = array();
        $store = Store::find($store_id);
        if ($store->lang_code != null) {
            $lang = $store->lang_code;
            if ($request['name_' . $lang] == null) $errors['name'] = __('messages.please_enter_name_' . $lang);
            if ($request['description_' . $lang] == null) $errors['description'] = __('messages.please_enter_description_' . $lang);
        } else {
            if ($request['name_ar'] == null || $request['name_en'] == null) $errors['name'] = __('messages.please_enter_name_both');
            if ($request['description_ar'] == null || $request['description_en'] == null) $errors['description'] = __('messages.please_enter_description_both');
        }
        if (!empty($errors)) return back()->withErrors($errors);
        $data = array();
        $request['is_active'] != null ? $data['is_active'] = 1 : $data['is_active'] = 0;
        $data['store_id'] = $store->id;
        if ($request['name_ar'] != null) $data['name_ar'] = $request['name_ar'];
        if ($request['name_en'] != null) $data['name_en'] = $request['name_en'];
        if ($request['description_ar'] != null) $data['description_ar'] = $request['description_ar'];
        if ($request['description_en'] != null) $data['description_en'] = $request['description_en'];
        $data['discount'] = $request['discount'];
        $data['type'] = $request['discount_type'];
        $data['code'] = $request['code'];
        $coupon->update($data);
        return redirect('store/coupons');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon = Coupon::find($id);
        $store = Store::find(get_current_store());
        if($coupon->store_id != $store->id) return abort(403);
        $coupon->delete();
        return back()->with(['success'=>__('messages.delete_success')]);
    }
}
