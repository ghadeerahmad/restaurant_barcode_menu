<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\Edit;
use App\Models\Product;
use App\Models\ProductAddon;
use App\Models\ProductCategory;
use App\Models\ProductEdit;
use App\Models\ProductSauce;
use App\Models\Sauce;
use App\Models\Store;
use App\Models\StorePrivilege;
use App\Models\UserStorePrivilege;
use Illuminate\Http\Request;

class BrancheController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        get_locale();
        $branches = Store::where('parent_id', get_current_store())->get();
        return view('store.branches.index', ['branches' => $branches]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        get_locale();
        $store = Store::with(['currency', 'plan'])->find(get_current_store());
        $plan_roles = $store->plan->plan_roles;
        return view('store.branches.add', ['store' => $store, 'roles' => $plan_roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $store = Store::with(['currency', 'branches'])->find(get_current_store());
        if ($store->max_branches == 0) return abort(403);
        if (count($store->branches) >= $store->max_branches) return back()->withErrors(['error' => __('messages.reached_maximum_branches')]);
        request()->validate([
            'name_ar' => 'nullable|max:50',
            'name_en' => 'nullable|max:50',
            'description_ar' => 'nullable|max:255',
            'description_en' => 'nullable|max:255',

        ]);
        $errors = array();
        if ($store->lang_code != null) {
            $lang = $store->lang_code;
            if ($request['name_' . $lang] == null) $errors['name'] = __('messages.please_enter_name_' . $lang);
            if ($request['description_' . $lang] == null) $errors['description'] = __('messages.please_enter_description_' . $lang);
            if ($request['address_' . $lang] == null) $errors['address'] = __('messages.please_enter_address_' . $lang);
        } else {
            if ($request['name_ar'] == null || $request['name_en'] == null) $errors['name'] = __('messages.please_enter_name_both');
            if ($request['description_ar'] == null || $request['description_en'] == null) $errors['description'] = __('messages.please_enter_description_both');
            if ($request['address_ar'] == null || $request['address_en'] == null) $errors['address'] = __('messages.please_enter_address_both');
        }
        if (!empty($errors)) return back()->withErrors($errors);
        $data = array();
        $data['parent_id'] = $store->id;
        $data['admin_id'] = auth()->user()->id;
        $data['currency_id'] = $store->currency_id;
        $data['plan_id'] = $store->plan_id;
        $data['sub_end'] = $store->sub_end;
        $data['logo'] = $request['logo'] != null ? $request['logo'] : $store->logo;
        if ($store->lang_code != null) $data['lang_code'] = $store->lang_code;
        if ($request['name_ar'] != null) $data['name_ar'] = $request['name_ar'];
        if ($request['name_en'] != null) $data['name_en'] = $request['name_en'];
        if ($request['description_ar'] != null) $data['description_ar'] = $request['description_ar'];
        if ($request['description_en'] != null) $data['description_en'] = $request['description_en'];
        if ($request['address_ar'] != null) $data['address_ar'] = $request['address_ar'];
        if ($request['address_en'] != null) $data['address_en'] = $request['address_en'];
        if ($request['delivery_fees'] != null) $data['delivery_fees'] = $request['delivery_fees'];
        if ($request['delivery_area'] != null) $data['delivery_area'] = $request['delivery_area'];
        if ($request['longtude'] != null) $data['longtude'] = $request['longtude'];
        if ($request['latitude'] != null) $data['latitude'] = $request['latitude'];
        $branch = Store::create($data);
        if ($branch) {
            $privilege = StorePrivilege::where('is_default', 1)->first();
            if ($privilege != null) {
                UserStorePrivilege::create(['user_id' => auth()->user()->id, 'store_id' => $branch->id, 'store_privilege_id' => $privilege->id]);
            }
            return back()->with(['success' => __('messages.create_success')]);
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
        $branch = Store::with(['currency', 'parent', 'plan'])->find($id);
        $roles = $branch->plan->plan_roles;
        return view('store.branches.update', [
            'branch' => $branch,
            'store' => $branch->parent,
            'roles' => $roles
        ]);
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
        $branch = Store::find($id);
        request()->validate([
            'name_ar' => 'nullable|max:50',
            'name_en' => 'nullable|max:50',
            'description_ar' => 'nullable|max:255',
            'description_en' => 'nullable|max:255',
            'address_ar' => 'nullable|max:255',
            'address_en' => 'nullable|max:255'
        ]);
        $errors = array();
        if ($branch->lang_code != null) {
            $lang = $branch->lang_code;
            if ($request['name_' . $lang] == null) $errors['name'] = __('messages.please_enter_name_' . $lang);
            if ($request['description_' . $lang] == null) $errors['description'] = __('messages.please_enter_description_' . $lang);
            if ($request['address_' . $lang] == null) $errors['address'] = __('messages.please_enter_address_' . $lang);
        } else {
            if ($request['name_ar'] == null || $request['name_en'] == null) $errors['name'] = __('messages.please_enter_name_both');
            if ($request['description_ar'] == null || $request['description_en'] == null) $errors['description'] = __('messages.please_enter_description_both');
            if ($request['address_ar'] == null || $request['address_en'] == null) $errors['address'] = __('messages.please_enter_address_both');
        }
        if (!empty($errors)) return back()->withErrors($errors);
        $data = array();
        if ($request['logo'] != null) $data['logo'] = $request['logo'];
        if ($request['name_ar'] != null) $data['name_ar'] = $request['name_ar'];
        if ($request['name_en'] != null) $data['name_en'] = $request['name_en'];
        if ($request['description_ar'] != null) $data['description_ar'] = $request['description_ar'];
        if ($request['description_en'] != null) $data['description_en'] = $request['description_en'];
        if ($request['address_ar'] != null) $data['address_ar'] = $request['address_ar'];
        if ($request['address_en'] != null) $data['address_en'] = $request['address_en'];
        if ($request['delivery_fees'] != null) $data['delivery_fees'] = $request['delivery_fees'];
        if ($request['delivery_area'] != null) $data['delivery_area'] = $request['delivery_area'];
        if ($request['longtude'] != null) $data['longtude'] = $request['longtude'];
        if ($request['latitude'] != null) $data['latitude'] = $request['latitude'];
        $branch->update($data);
        return back()->with(['success' => __('messages.update_success')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch = Store::find($id);
        ProductCategory::where('store_id', $id)->delete();
        Product::where('store_id', $id)->delete();
        Addon::where('store_id', $id)->delete();
        Edit::where('store_id', $id)->delete();
        Sauce::where('store_id', $id)->delete();
        $branch->delete();
        return back()->with(['success' => __('messages.delete_success')]);
    }
}
