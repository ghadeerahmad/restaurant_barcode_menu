<?php

namespace App\Http\Controllers\visitor;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\Store;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class TableController extends Controller
{
    /**
     * display intro image
     * @param Store $store
     * @param Table $table
     * @return \Illuminate\Http\Response
     */
    public function index(Store $store, Table $table)
    {
        get_locale();
        $locale = App::currentLocale();
        if ($table->store_id != $store->id) return abort(404);
        if ($store->status != 1) return abort(404);
        if ($table->is_active != 1) return abort(404);
        session(['table' => $table->id]);
        if ($store == null) return abort(404);
        session(['store_id'=>$store->id]);
        return view('visitors.menu.intro',['store'=>$store,'work_days'=>$store->work_days]);
    }
    /**
     * get menu for this table
     * @return \Illuminate\Http\Response
     */
    public function menu(){
        get_locale();
        $locale = App::currentLocale();
        if(session('table') == null) return abort(404);
        $table = Table::with(['store'])->find(session('table'));
        $store = $table->store;
        if ($table->store_id != $store->id) return abort(404);
        if ($store->status != 1) return abort(404);
        if ($table->is_active != 1) return abort(404);
        //session(['table' => $table->id]);
        if ($store == null) return abort(404);
        session(['store_id'=>$store->id]);
        $cates = ProductCategory::with(['products'])->where('is_active', 1)
            ->where('store_id', $store->id)->get();
        return view('visitors.tables.index', [
            'store' => $store,
            'cates' => $cates,
            'locale' => $locale,
            'table' => $table
        ]);
    }
}
