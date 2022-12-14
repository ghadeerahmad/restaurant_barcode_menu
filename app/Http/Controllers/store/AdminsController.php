<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\StoreAdmin;
use App\Models\StorePrivilege;
use App\Models\User;
use App\Models\UserStorePrivilege;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        get_locale();
        $store_id = get_current_store();
        $store = Store::with(['users'])->find($store_id);
        return view('store.users.index', [
            'store' => $store,
            'users' => $store->users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        get_locale();
        $privileges = StorePrivilege::all();
        return view('store.users.create', ['privileges' => $privileges]);
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
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'privilege' => 'required'
        ]);
        $store_id = get_current_store();
        $request['password'] = Hash::make($request['password']);
        $user = User::create($request->except('privilege'));
        if ($user) {
            StoreAdmin::create(['user_id' => $user->id, 'store_id' => $store_id]);
            UserStorePrivilege::create(['user_id' => $user->id, 'store_id' => $store_id, 'store_privilege_id' => $request['privilege']]);
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
        get_locale();
        $store_id = get_current_store();
        $admin = UserStorePrivilege::where('user_id', $id)
            ->where('store_id', $store_id)
            ->first();
        if ($admin == null) return abort(404);
        $user = User::find($id);
        return view('store.users.show', ['user' => $user]);
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
        $store_id = get_current_store();
        $admin = UserStorePrivilege::where('user_id', $id)
            ->where('store_id', $store_id)
            ->first();
        if ($admin == null) return abort(404);
        $privileges = StorePrivilege::all();
        $user = User::find($id);
        return view('store.users.update', ['privilege_id' => $admin->store_privilege_id, 'user' => $user, 'privileges' => $privileges]);
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
        request()->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email',
            'password' => 'nullable',
            'privilege' => 'required'
        ]);

        $data = [
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
        ];
        $user = User::find($id);
        $store_id = get_current_store();
        if ($request['password'] != null) $data['password'] = Hash::make($request['password']);
        //$store_admin = StoreAdmin::where('user_id', $id)->where('store_id', $store_id)->first();
        $store_privilege = UserStorePrivilege::where('user_id', $id)->where('store_id', $store_id)->first();
        $user->update($data);
        //$store_admin->update(['user_id' => $user->id, 'store_id' => $store_id]);
        $store_privilege->update(['store_privilege_id' => $request['privilege']]);
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
        $user = User::find($id);
        if ($user == null) return abort(404);
        $store_id = get_current_store();
        UserStorePrivilege::where('user_id', $id)
            ->where('store_id', $store_id)
            ->delete();
        StoreAdmin::where('user_id', $id)
            ->where('store_id', $store_id)->delete();
        return back()->with(['success' => __('messages.delete_success')]);
    }
    /** 
     * set a user as admin to store
     * @param \Illuminate\Http\Request $request
     */
    public function set_admin(Request $request)
    {
        get_locale();
        request()->validate([
            'email' => 'required',
            'privilege' => 'required'
        ]);
        $user = User::where('email', $request['email'])->first();
        if ($user == null) return back()->withErrors(['errors' => __('messages.user_not_found')]);
        $store_id = get_current_store();
        $user_privilege = UserStorePrivilege::create(['user_id' => $user->id, 'store_id' => $store_id, 'store_privilege_id' => $request['privilege']]);
        $store_admin = StoreAdmin::create(['user_id' => $user->id, 'store_id' => $store_id]);
        if ($user_privilege && $store_admin) return back()->with(['success' => __('messages.create_success')]);
    }
}
