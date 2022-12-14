<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Store;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Store $store)
    {
        $cates = $store->productCategories();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        get_locale();
        $store_id = get_current_store();
        $store = Store::find($store_id);
        return view('store.categories.add', ['store' => $store]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $store = Store::find(get_current_store());
        //dd($store);
        request()->validate([
            'name_ar' => 'nullable|max:50',
            'name_en' => 'nullable|max:50',
            'is_active' => 'required',
            'image' => 'required',

        ]);
        $data = array();
        $errors = array();
        if (check_lang_code($store->lang_code) != null) {
            if ($request['name_' . $store->lang_code] == null)
                $errors['name'] =  __('messages.please_enter_name_' . $store->lang_code);
        } else {
            if ($request['name_ar'] == null || $request['name_en'] == null)
                $errors['name'] = __('messages.please_enter_name_both');
        }
        if (!empty($errors)) return back()->withErrors($errors);
        $data['store_id'] = $store->id;
        $data['image'] = $request['image'];
        $data['is_active'] = $request['is_active'];
        if ($request['name_ar'] != null) $data['name_ar'] = $request['name_ar'];
        if ($request['name_en'] != null) $data['name_en'] = $request['name_en'];
        $cate = ProductCategory::create($data);
        if ($cate) return redirect('store/inventory');
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
        $cate = ProductCategory::find($id);
        if ($cate == null) return abort(404);
        $store = Store::find(get_current_store());
        if ($cate->store_id != $store->id) return abort(403);
        return view('store.categories.update', ['cate' => $cate, 'lang_code' => $store->lang_code]);
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
        $cate = ProductCategory::find($id);


        $data = request()->validate([
            'name_ar' => 'nullable|max:50',
            'name_en' => 'nullable|max:50',
            'is_active' => 'nullable',
            'image' => 'nullable',

        ]);
        $cate->update($data);
        if ($cate) return back()->with(['success' => __('messages.update_success')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cate = ProductCategory::find($id);
        if ($cate == null) return abort(404);
        $image = $cate->image;
        try {
            Storage::disk('public')->delete($image);
        } catch (Exception $e) {
        }
        $products = Product::where('product_category_id', $id)->delete();

        $cate->delete();
        return back()->with(['success' => __('messages.delete_success')]);
    }
}
