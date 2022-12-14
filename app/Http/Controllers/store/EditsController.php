<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Models\Edit;
use App\Models\Store;
use Illuminate\Http\Request;

class EditsController extends Controller
{
    public function getEditsJson(Store $store){
        $edites = $store->edits();
        return response()->json(['edits'=>$edites]);
    }
    public function create(Request $request){
        $store = Store::find(get_current_store());
        if($store->lang_code != null){
            if($request['name_'.$store->lang_code] == null) return back()->withErrors(['name'=>__('messages.please_enter_name_'.$store->lang_code)]);
        }else{
            if($request['name_ar'] == null || $request['name_en'] == null) return back()->withErrors(['name'=>__('please_enter_name_both')]); 
        }
        $data = array();
        if($request['name_ar'] != null) $data['name_ar'] = $request['name_ar'];
        if($request['name_en'] != null) $data['name_en'] = $request['name_en'];
        $data['store_id'] = get_current_store();
        if(Edit::create($data)) return back()->with(['success'=>__('messages.create_success')]);
    }
    public function update(Edit $edit){
        $data = request()->validate([
            'name'=>'required|max:255'
        ]);
        $edit->update($data);
        return back()->with(['success'=>__('messages.update_success')]);
    }
    public function delete($id){
        $edit = Edit::find($id);
        $edit->delete();
        return back()->with(['success'=>__('messages.delete_success')]);
    }
}
