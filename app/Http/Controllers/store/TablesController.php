<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TablesController extends Controller
{
    public function index()
    {
        get_locale();
        $store = Store::with(['tables'])->find(get_current_store());

        $tables = $store->tables;
        return view('store.tables.index', [
            'tables' => $tables
        ]);
    }
    public function add()
    {
        get_locale();
        return view('store.tables.add');
    }
    public function create(Request $request)
    {

        $data = request()->validate([
            'name' => 'required|max:50',
        ]);
        $request['is_active'] != null ? $data['is_active'] = 1 : $data['is_active'] = 0;
        $data['store_id'] = get_current_store();
        $code = Str::random(10);
        $r = true;
        while ($r) {
            $code2 = Table::where('code', $code)->first();
            if ($code2 == null) $r = false;
            else $code = Str::random(10);
        }
        $data['code'] = $code;
        if (Table::create($data)) return redirect('store/tables');
    }
    public function print_qr($id)
    {
        get_locale();
        $table = Table::find($id);
        return view('store.tables.print_qr', ['table' => $table]);
    }
    public function delete($id)
    {
        $table = Table::find($id);
        if ($table->store_id != get_current_store()) return abort(403);
        $table->delete();
        return back()->with(['success' => __('messages.delete_success')]);
    }
}
