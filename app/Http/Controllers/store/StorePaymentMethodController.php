<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Models\StorePaymentMethod;
use App\Models\Store;
use Illuminate\Http\Request;

class StorePaymentMethodController extends Controller
{
    public function add()
    {
        get_locale();
        $store = Store::find(get_current_store());
        return view('store.dashboard.settings.payment_method.add', ['store' => $store]);
    }

    public function create(Request $request)
    {
        $store = Store::find(get_current_store());
        request()->validate(
            [
                'title_ar'       => 'nullable|max:50',
                'title_en'       => 'nullable|max:50',
                'description_ar' => 'nullable:255',
                'description_en' => 'nullable:255',
                'image'          => 'nullable|mimes:jpg,png,jpeg|max:2048',
                'account_number' => 'nullable'
            ]
        );
        $errors = array();
        if ($store->lang_code != null) {
            switch ($store->lang_code) {
                case 'ar':
                    if (empty($request['title_ar'])) $errors['title_ar'] = __('messages.please_enter_title_ar');
                    if (empty($request['description_ar'])) $errors['description_ar'] =  __('messages.please_enter_description_ar');
                    break;
                case 'en':
                    if (empty($request['title_en'])) $errors['title_en'] = __('messages.please_enter_title_en');
                    if (empty($request['description_en'])) $errors['description_en'] = __('messages.please_enter_description_en');
                    break;
                default:
                    if (empty($request['title_ar']) || empty($request['title_en'])) $errors['title'] = __('messages.please_enter_title_both');
                    if (empty($request['description_ar']) || empty($request['description_en'])) $errors['description'] = __('messages.please_enter_description_both');
            }
        }
        if (!empty($errors)) return back()->withErrors($errors);

        $data = array();
        $data['store_id'] = $store->id;
        if ($request['title_ar'] != null) $data['title_ar'] = $request['title_ar'];
        if ($request['title_en'] != null) $data['title_en'] = $request['title_en'];
        if ($request['description_ar'] != null) $data['description_ar'] = $request['description_ar'];
        if ($request['description_en'] != null) $data['description_en'] = $request['description_en'];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $path = $request->file('image')->storeAs('stores', $image_name, 'public');
            $data['image'] = $path;
        }

        if ($request['account_number'] != null) $data['account_number'] = $request['account_number'];
        $request['is_active'] != null ? $data['is_active'] = 1 : $data['is_active'] = 0;

        $store_payment_method = StorePaymentMethod::create($data);
        if ($store_payment_method) return redirect('store/settings');
    }
    public function edit($id)
    {
        get_locale();
        $store_payment_method = StorePaymentMethod::find($id);
        $store = Store::find(get_current_store());
        return view('store.dashboard.settings.payment_method.update', ['store_payment_method' => $store_payment_method, 'store' => $store]);
    }
    public function update(Request $request, $id)
    {
        $store_payment_method = StorePaymentMethod::find($id);
        $store = Store::find(get_current_store());
        request()->validate(
            [
                'title_ar'       => 'nullable|max:20',
                'title_en'       => 'nullable|max:20',
                'description_ar' => 'nullable:255',
                'description_en' => 'nullable:255',
                'image'          => 'nullable|mimes:jpg,png,jpeg|max:5048',
                'account_number' => 'nullable'
            ]
        );
        $errors = array();
        if ($store->lang_code != null) {
            switch ($store->lang_code) {
                case 'ar':
                    if (empty($request['title_ar'])) $errors['title_ar'] = __('messages.please_enter_title_ar');
                    if (empty($request['description_ar'])) $errors['description_ar'] =  __('messages.please_enter_description_ar');
                    break;
                case 'en':
                    if (empty($request['title_en'])) $errors['title_en'] = __('messages.please_enter_title_en');
                    if (empty($request['description_en'])) $errors['description_en'] = __('messages.please_enter_description_en');
                    break;
                default:
                    if (empty($request['title_ar']) || empty($request['title_en'])) $errors['title'] = __('messages.please_enter_title_both');
                    if (empty($request['description_ar']) || empty($request['description_en'])) $errors['description'] = __('messages.please_enter_description_both');
            }
        }
        if (!empty($errors)) return back()->withErrors($errors);

        $data = array();
        $data['store_id'] = $store->id;
        if ($request['title_ar'] != null) $data['title_ar'] = $request['title_ar'];
        if ($request['title_en'] != null) $data['title_en'] = $request['title_en'];
        if ($request['description_ar'] != null) $data['description_ar'] = $request['description_ar'];
        if ($request['description_en'] != null) $data['description_en'] = $request['description_en'];
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $path = $request->file('image')->storeAs('stores', $image_name, 'public');
            $data['image'] = $path;
        }
        if ($request['account_number'] != null) $data['account_number'] = $request['account_number'];
        $request['is_active'] != null ? $data['is_active'] = 1 : $data['is_active'] = 0;

        $store_payment_method->update($data);
        if ($store_payment_method) return redirect('store/settings');
    }
    public function delete($id)
    {
        $store_payment_method = StorePaymentMethod::find($id);
        $store = Store::find(get_current_store());
        $store_payment_method->delete();
        return back()->with(['success' => __('messages.delete_success')]);
    }
}
