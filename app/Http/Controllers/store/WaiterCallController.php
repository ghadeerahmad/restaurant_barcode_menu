<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Models\Table;
use App\Models\WaiterCall;
use Illuminate\Http\Request;

class WaiterCallController extends Controller
{
    /**
     * get all calls for current store
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        get_locale();
        $store_id = get_current_store();
        $calls = WaiterCall::with(['table'])->where('store_id', $store_id)->orderBy('created_at','DESC')->get();
        return view('store.waiter_call.index', ['calls' => $calls]);
    }
    /**
     * set call as completed
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function set_completed(Request $request)
    {
        get_locale();
        request()->validate(['id'=>'required']);
        $store_id = get_current_store();
        $table = WaiterCall::where('id',$request['id'])->where('store_id',$store_id)->first();
        if ($table == null) return abort(404);
        $completed = 1;
        if($table->is_completed == 1) $completed = 0;
        $table->is_completed = $completed;
        $table->save();
        return response()->json(['message'=>__('messages.success')]);
    }
    public function check(){
        get_locale();
        $store_id = get_current_store();
        $calls = WaiterCall::where('store_id',$store_id)->where('is_completed',0)->first();
        if($calls != null){
            //$calls = WaiterCall::where('store_id',$store_id)->get();
            return response()->json(['message'=>'success']);
        }
        return response()->json(['message'=>'non']);
    }
    /**
     * delete record
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        //get_locale();
        $store_id = get_current_store();
        $call = WaiterCall::where('store_id',$store_id)->where('id',$id)->first();
        if($call == null) return abort(404);
        $call->delete();
        return back();

    }
}
