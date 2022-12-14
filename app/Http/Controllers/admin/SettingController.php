<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    /**
     * display settings page
     * @return \Illuminate\Http\Response
     */
    public function index(){
        get_locale();
        $settings = Setting::all();
        return view('admin.settings.index',['settings'=>$settings]);
    }
    /**
     * update settings 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            'branche_cost'=>'nullable',
            'privacy_policy'=>'nullable',
            'terms_ofUse'=>'nullable'
        ]);
        $data = array();
        if($request['branche_cost'] != null) $data['BranchCost'] = $request['branche_cost'];
        if($request['privacy_policy'] != null) $data['privacy_policy'] = $request['privacy_policy'];
        if($request['terms_ofUse'] != null) $data['terms_ofUse'] = $request['terms_ofUse'];
        foreach($data as $key => $value){
            Setting::where('key',$key)->update(['value'=>$value]);
        }
        return back()->with(['success'=>__('messages.update_success')]);
    }
    /**
     * show privacy policy and terms of use page
     * @return \Illuminate\Http\Response
     */
    public function privacy_terms(){
        get_locale();
        $settings = Setting::where('key','privacy_ar')
        ->orWhere('key','privacy_en')
        ->orWhere('key','terms_ar')
        ->orWhere('key','terms_en')
        ->get();
        return view('admin.settings.privacy_terms',['settings'=>$settings]);
    }
    /**
     * update privacy policy and terms of use
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update_privacy_terms(Request $request){
        request()->validate([
            'privacy_ar'=>'required',
            'privacy_en'=>'required',
            'terms_ar'=>'required',
            'terms_en'=>'required'
        ]);
        foreach($request->all() as $key => $value){
            Setting::where('key',$key)->update(['value'=>$value]);
        }
        return back()->with(['success'=>__('messages.update_success')]);
    }
}
