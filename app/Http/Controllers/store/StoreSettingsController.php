<?php

namespace App\Http\Controllers\store;

use App\Exports\StoreAdminExport;
use App\Exports\StoresExport;
use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use App\Models\Store;
use App\Models\WorkDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class StoreSettingsController extends Controller
{
  public function create(Request $request)
  {
    $store = Store::find(get_current_store());

    request()->validate([
      'primary_color'    => 'nullable',
      'secondary_color'  => 'nullable',
      'text_color'       => 'nullable',
      'fav_icon'         => 'nullable|mimes:ico'
    ]);

    $data = array();
    $data['store_id'] = $store->id;
    if ($request['primary_color'] != null) $data['primary_color'] = $request['primary_color'];
    if ($request['secondary_color'] != null) $data['secondary_color'] = $request['secondary_color'];
    if ($request['text_color'] != null) $data['text_color'] = $request['text_color'];
    // if ($request->hasFile('background_image')) {
    //   $image = $request->file('background_image');
    //   $image_name = $image->getClientOriginalName();
    //   $path = $request->file('background_image')->storeAs('stores', $image_name, 'public');

    //   $data['background_image'] = $path;
    // }

    if ($request->hasFile('fav_icon')) {
      $image = $request->file('fav_icon');
      $image_name = $image->getClientOriginalName();
      $path = $request->file('fav_icon')->storeAs('stores', $image_name, 'public');

      $data['fav_icon'] = $path;
    }

    $store_setting = StoreSetting::create($data);
    if ($store_setting) return back()->with(['success' => __('messages.update_success')]);
  }
  /**
   * update week days 
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function update_days(Request $request)
  {
    get_locale();
    request()->validate([
      'opening_time' => 'array',
      'closing_time' => 'array',
      'is_off' => 'array'
    ]);
    $data = array();
    $days = ['sat', 'sun', 'mon', 'tue', 'wed', 'thu', 'fri'];
    $store_id = get_current_store();
    $i = 0;
    $work_days = WorkDay::where('store_id', $store_id)->get();
    while ($i < 7) {
      $day = array();
      $day['store_id'] = $store_id;
      $day['day'] = $days[$i];
      $day['opening_time'] = $request['opening_time'][$i];
      $day['closing_time'] = $request['closing_time'][$i];
      $day['is_off'] = $request['is_off'][$i];
      array_push($data, $day);
      $i++;
    }
    if (count($work_days) > 0) {
      $i = 0;
      while ($i < 7) {
        $work_days[$i]->update($data[$i]);
        $i++;
      }
    } else
      WorkDay::insert($data);
    return back()->with(['success' => __('messages.update_success')]);
  }
  /**
   * update orders settings
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function update_order_settings(Request $request)
  {
    get_locale();
    request()->validate([
      'delivery' => 'required',
      'cash' => 'required',
      'other_payment' => 'required'
    ]);
    $store_id = get_current_store();
    $data = array();
    $data['is_delivery_enabled'] = $request['delivery'];
    $data['is_cash_enabled'] = $request['cash'];
    $data['other_payment_enabled'] = $request['other_payment'];
    $settings = StoreSetting::where('store_id', $store_id)->first();
    if ($settings != null) {
      $settings->update($data);
      return response()->json(['status' => 1, 'message' => __('messages.update_success')]);
    }
    $data['store_id'] = $store_id;
    if (StoreSetting::create($data)) return response()->json(['status' => 1, 'message' => __('messages.update_success')]);
  }
  
    /**
     * view statistics
     * @return \Illuminate\Http\Response
     */
    public function statistics()
    {
        get_locale();
        $store_id = get_current_store();
        $stores = Store::with(['tables', 'product_categories', 'products', 'orders', 'branches', 'plan'])
            ->find($store_id);
        return view('store.dashboard.settings.statistics', ['store' => $stores]);
    }
    /**
     * display orders count and value between tow dates
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function filter_by_date(Request $request)
    {
        get_locale();
        $store_id = get_current_store();
        request()->validate([
            'start' => 'required',
            'end' => 'nullable'
        ]);
        $stores = Store::with(['tables', 'product_categories', 'products', 'orders', 'branches', 'plan'])
            ->find($store_id);
        $ordersCount = null;
        if ($request['end'] != null) {
            // $ordersCount = DB::table('orders')
            // ->select(DB::raw('count(id) as ordersCount,SUM(total) as total,store_id,'))
            // ->whereDate('created_at','>=',$request['start'])
            // ->whereDate('created_at','<=',$request['end'])
            // ->groupBy('store_id')
            // ->get();

            $ordersCount = DB::table('orders')
                ->select(DB::raw('count(id) as ordersCount,SUM(total) as total,store_id'))
                ->whereDate('created_at', '>=', $request['start'])
                ->whereDate('created_at', '<=', $request['end'])
                ->groupBy('store_id')
                ->get();
        } else {
            $ordersCount = DB::table('orders')
                ->select(DB::raw('count(id) as ordersCount,SUM(total) as total,store_id'))
                ->whereDate('created_at', '>=', $request['start'])
                ->groupBy('store_id')
                ->get();
        }
        //dd($ordersCount);
        return view('store.dashboard.settings.statistics', ['store' => $stores, 'orders' => $ordersCount]);
    }
    /**
     * download excel sheet
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function get_sheet(Request $request)
    {
        $orders = null;
        get_locale();
        $store_id = get_current_store();
        if ($request['start'] != null) {
            if ($request['end'] != null) {
                $orders = DB::table('orders')
                    ->select(DB::raw('count(id) as ordersCount,SUM(total) as total,store_id'))
                    ->whereDate('created_at', '>=', $request['start'])
                    ->whereDate('created_at', '<=', $request['end'])
                    ->groupBy('store_id')
                    ->get();
            } else {
                $orders = DB::table('orders')
                    ->select(DB::raw('count(id) as ordersCount,SUM(total) as total,store_id'))
                    ->whereDate('created_at', '>=', $request['start'])
                    ->groupBy('store_id')
                    ->get();
            }
        }
        $stores = Store::with(['tables', 'product_categories', 'products', 'orders', 'branches', 'plan'])
            ->find($store_id);
        $data = ['store' => $stores];
        if ($orders != null) $data['orders'] = $orders;
        //dd($data);
        return Excel::download(new StoreAdminExport($data), 'stores.xls');
    }
}
