<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        get_locale();
        $themes = Theme::with(['store'])->get();
        return view('admin.themes.index', ['themes' => $themes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        get_locale();
        return view('admin.themes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        get_locale();
        request()->validate([
            'name' => 'required',
            'background_image' => 'nullable|mimes:jpg,jpeg,png,gif|max:2048',
            'intro_image' => 'nullable|mimes:jpg,jpeg,png,gif|max:2048'
        ]);
        $data = [
            'name' => $request['name']
        ];
        if ($request['is_default'] != null) $data['is_default'] = $request['is_default'];
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
        $theme = Theme::find($id);
        return view('admin.themes.update', ['theme' => $theme]);
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
        get_locale();
        $theme = Theme::find($id);
        if ($theme == null) return abort(404);
        request()->validate([
            'name' => 'required',
            'background_image' => 'nullable|mimes:jpg,jpeg,png,gif|max:2048',
            'intro_image' => 'nullable|mimes:jpg,jpeg,png,gif|max:2048'
        ]);
        $data = [
            'name' => $request['name']
        ];
        if ($request['is_default'] != null) $data['is_default'] = $request['is_default'];
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
            if ($theme->background_image != null) Storage::disk('public')->delete($theme->background_image);
            $file = $request->file('background_image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('themes', $fileName, 'public');
            $theme->background_image = $path;
            $theme->save();
        }
        if ($request->hasFile('intro_image')) {
            if ($theme->intro_image != null) Storage::disk('public')->delete($theme->intro_image);
            $file = $request->file('intro_image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('themes', $fileName, 'public');
            $theme->intro_image = $path;
            $theme->save();
        }
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
        get_locale();
        $theme = Theme::find($id);
        if ($theme != null) {
            $stores = Store::where('active_theme_id', $id)->get();
            foreach ($stores as $store) {
                $store->active_theme_id = 0;
                $store->save();
            }
            if ($theme->background_image != null) Storage::disk('public')->delete($theme->background_image);
            $theme->delete();
        }
        return back();
    }
}
