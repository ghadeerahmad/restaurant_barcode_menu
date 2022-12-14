<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ThemeController extends Controller
{
    /**
     * get store themes
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        get_locale();
        $store_id = get_current_store();
        $themes = Theme::where('store_id', $store_id)->WhereNull('store_id')->get();
        return view('store.dashboard.settings.themes.index', ['themes' => $themes]);
    }
    /**
     * create new theme
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        get_locale();
        return view('store.dashboard.settings.themes.create');
    }
    /**
     * update theme page
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        get_locale();
        $store_id = get_current_store();
        $theme = Theme::where('id', $id)->where('store_id', $store_id)->first();
        if ($theme == null) return abort(404);
        return view('store.dashboard.settings.themes.update', ['theme' => $theme]);
    }
    /**
     * save store theme info
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'background_image' => 'nullable|mimes:jpg,jpeg,gif,png|max:2048',
            'intro_image' => 'nullable|mimes:jpg,jpeg,gif,png|max:2048',
        ]);
        $store_id = get_current_store();
        $store = Store::find($store_id);
        $data = [
            'store_id' => $store_id,
            'name' => get_local_name($store->name_ar, $store->name_en)
        ];
        if ($request['container_back_color'] != null) {
            $data['information_class_background'] = $request['container_back_color'];
            $data['info_product_class_background'] = $request['container_back_color'];
        }
        if ($request['container_fore_color'] != null) {
            $data['information_class_color'] = $request['container_fore_color'];
            $data['info_product_class_color'] = $request['container_fore_color'];
        }
        if ($request['primary_color'] != null) $data['primary_color'] = $request['primary_color'];
        if ($request['secondary_color'] != null) $data['secondary_color'] = $request['secondary_color'];
        if ($request['font_color'] != null) $data['font_color'] = $request['font_color'];
        if ($request['price_back_color'] != null) $data['price_back_color'] = $request['price_back_color'];
        if ($request['price_font_color'] != null) $data['price_font_color'] = $request['price_font_color'];
        $theme = Theme::create($data);
        if ($theme) {
            if ($request->hasFile('background_image')) {
                $file = $request->file('background_image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('themes', $fileName, 'public');
                $theme->background_image = $path;
                $theme->save();
            }
            if ($request->hasFile('intro_image')) {
                $file = $request->file('intro_image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('themes', $fileName, 'public');
                $theme->intro_image = $path;
                $theme->save();
            }
            if ($request['is_active'] != null && $request['is_active'] == 1) {
                $store_id = get_current_store();
                $store = Store::find($store_id);
                $store->active_theme_id = $theme->id;
                $store->save();
            }
            return back()->with(['success' => __('messages.create_success')]);
        }
    }
    /**
     * update theme 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $theme = Theme::find($id);
        request()->validate([
            'background_image' => 'nullable|mimes:jpg,jpeg,gif,png|max:2048',
        ]);
        $store_id = get_current_store();
        if ($theme->store_id != $store_id) return abort(404);

        if ($request['container_back_color'] != null) {
            $data['information_class_background'] = $request['container_back_color'];
            $data['info_product_class_background'] = $request['container_back_color'];
        }
        if ($request['container_fore_color'] != null) {
            $data['information_class_color'] = $request['container_fore_color'];
            $data['info_product_class_color'] = $request['container_fore_color'];
        }
        if ($request['primary_color'] != null) $data['primary_color'] = $request['primary_color'];
        if ($request['secondary_color'] != null) $data['secondary_color'] = $request['secondary_color'];
        if ($request['font_color'] != null) $data['font_color'] = $request['font_color'];
        if ($request['price_back_color'] != null) $data['price_back_color'] = $request['price_back_color'];
        if ($request['price_font_color'] != null) $data['price_font_color'] = $request['price_font_color'];
        $theme->update($data);
        if ($request->hasFile('background_image')) {
            if ($theme->background_image != null)
                Storage::disk('public')->delete($theme->background_image);
            $file = $request->file('background_image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('themes', $fileName, 'public');
            $theme->background_image = $path;
            $theme->save();
        }
        if ($request->hasFile('intro_image')) {
            if ($theme->intro_image != null)
                Storage::disk('public')->delete($theme->intro_image);
            $file = $request->file('intro_image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('themes', $fileName, 'public');
            $theme->intro_image = $path;
            $theme->save();
        }
        if ($request['is_active'] != null && $request['is_active'] == 1) {
            $store_id = get_current_store();
            $store = Store::find($store_id);
            $store->active_theme_id = $theme->id;
            $store->save();
        }
        return back()->with(['success' => __('messages.update_success')]);
    }
    /**
     * delete theme
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $store_id = get_current_store();
        $theme = Theme::find($id);
        if ($theme->store_id != $store_id) return abort(404);
        if ($theme->background_image != null)
            Storage::disk('public')->delete($theme->background_image);
        $store = Store::find($store_id);
        if ($store->active_theme_id == $id) {
            $store->active_theme_id = 0;
            $store->save();
        }
        $theme->delete();
        return back()->with(['success' => __('messages.success')]);
    }
    /**
     * activate Theme
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function activate(Request $request){
        get_locale();
        request()->validate(['theme_id'=>'required']);
        $store_id = get_current_store();
        $store = Store::find($store_id);
        $store->active_theme_id = $request['theme_id'];
        $store->save();
        return response()->json(['status'=>1,'message'=>__('messages.success'),'tab'=>'theme']);
    }
}
