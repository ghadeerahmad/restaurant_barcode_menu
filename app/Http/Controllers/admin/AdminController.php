<?php

namespace App\Http\Controllers\admin;

use App\Exports\StoresExport;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\SitePrivilege;
use App\Models\Store;
use App\Models\StoreAdmin;
use App\Models\User;
use App\Models\UserStorePrivilege;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    /**
     * @param \Illuminate\Http\Response 
     */
    public function index()
    {
        get_locale();
        $users = User::where('site_privilege_id', '!=', NULL)
            ->where('site_privilege_id', '!=', 0)
            ->get();
        return view('admin.users.index', ['users' => $users]);
    }
    public function dashboard()
    {
        get_locale();
        $stores = Store::all();
        $plans = Plan::all();
        $approved = [];
        $unapproved = [];
        foreach ($stores as $store) {
            if ($store->status == 0) array_push($unapproved, $store);
            else array_push($approved, $store);
        }
        return view('admin.dashboard.index', [
            'approved' => $approved,
            'unapproved' => $unapproved,
            'plans' => $plans
        ]);
    }
    /**
     * view statistics
     * @return \Illuminate\Http\Response
     */
    public function statistics()
    {
        get_locale();
        $stores = Store::with(['tables', 'product_categories', 'products', 'orders', 'branches', 'plan'])
            ->orderBy('created_at', 'desc')->get();
        return view('admin.dashboard.statistics', ['stores' => $stores]);
    }
    /**
     * display orders count and value between tow dates
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function filter_by_date(Request $request)
    {
        get_locale();
        request()->validate([
            'start' => 'required',
            'end' => 'nullable'
        ]);
        $stores = Store::with(['tables', 'product_categories', 'products', 'orders', 'branches', 'plan'])
            ->orderBy('created_at', 'desc')->get();
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
        return view('admin.dashboard.statistics', ['stores' => $stores, 'orders' => $ordersCount]);
    }
    /**
     * download excel sheet
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function get_sheet(Request $request)
    {
        $orders = null;
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
            ->orderBy('created_at', 'desc')->get();
        $data = ['stores' => $stores];
        if ($orders != null) $data['orders'] = $orders;
        //dd($data);
        return Excel::download(new StoresExport($data), 'stores.xls');
    }
    public function approve($id)
    {
        get_locale();
        $store = Store::find($id);
        $store->status = 1;
        $store->save();
        return back()->with(['success' => __('messages.store_approved')]);
    }
    public function create()
    {
        get_locale();
        $privileges = SitePrivilege::all();
        return view('admin.users.create', ['privileges' => $privileges]);
    }
    /**
     * create new admin user
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        get_locale();
        $data = request()->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'site_privilege_id' => 'required'
        ]);
        $data['password'] = Hash::make($request['password']);
        //dd($data);
        $user = User::create($data);
        if ($user) {
            return back()->with(['success' => __('messages.create_success')]);
        }
    }
    /** update user page
     * @param int $id
     */
    public function edit($id)
    {
        get_locale();
        $user = User::find($id);
        if ($user == null) return abort(404);
        $privileges = SitePrivilege::all();
        return view('admin.users.update', [
            'user' => $user,
            'privileges' => $privileges
        ]);
    }
    /**
     * @param int $id
     * @param \Illuminate\Http\Request $request
     */
    public function update(Request $request, $id)
    {
        get_locale();
        $user = User::find($id);
        if ($user == null) return abort(404);
        request()->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email',
            'password' => 'nullable',
            'site_privilege_id' => 'required'
        ]);
        $data = [
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'site_privilege_id' => $request['site_privilege_id']
        ];
        if ($request['password'] != null) $data['password'] = Hash::make($request['password']);
        $user->update($data);
        return back()->with(['success' => __('messages.update_success')]);
    }
    /**
     * delete user
     * @param int $id
     */
    public function destroy($id)
    {
        get_locale();
        $user = User::find($id);
        StoreAdmin::where('user_id', $id)->delete();
        UserStorePrivilege::where('user_id', $id)->delete();
        $user->delete();
        return back()->with(['success' => __('messages.delete_success')]);
    }
    /**
     * remove site admin
     * @param int $id
     */
    public function remove_admin($id)
    {
        get_locale();
        $user = User::find($id);
        if ($user != null) {
            $user->update(['site_privilege_id' => 0]);
            return back()->with(['success' => __('messages.delete_success')]);
        }
    }
}
