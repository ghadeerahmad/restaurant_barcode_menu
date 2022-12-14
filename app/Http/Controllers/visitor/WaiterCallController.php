<?php

namespace App\Http\Controllers\visitor;

use App\Http\Controllers\Controller;
use App\Models\Table;
use App\Models\WaiterCall;
use Illuminate\Http\Request;

class WaiterCallController extends Controller
{
    /**
     * send waiter call request
     * @return \Illuminate\Http\Response
     */
    public function call_waiter()
    {
        get_locale();
        request()->validate(['comment' => 'nullable|max:255']);
        if (session('table') == null) return abort(404);
        $table_id = session('table');
        $table = Table::with(['store'])->find($table_id);
        $data = [
            'table_id' => $table_id,
            'store_id' => $table->store->id,
            'is_completed' => 0,
        ];
        //if ($request['comment'] != null) $data['comment'] = $request['comment'];
        $call = WaiterCall::create($data);
        if($call) return response()->json(['message'=>__('messages.success')]);
    }
}
