<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\StorePrivilege;
use App\Models\StorePrivilegeRole;
use App\Models\StoreRole;
use Illuminate\Http\Request;

class StorePrivilegeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        get_locale();
        $store_privileges = StorePrivilege::all();
        return view('admin.store_privileges.index', [
            'privileges' => $store_privileges
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
        $store_roles = StoreRole::all()->groupBy('group');
        return view('admin.store_privileges.add', ['roles' => $store_roles]);
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
            'name_ar' => 'required|max:50',
            'name_en' => 'required|max:50',
            'roles' => 'required|array'
        ]);
        $data = [
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en']
        ];
        $request['is_default'] != null ? $data['is_default'] = $request['is_default'] : 0;
        $privilege = StorePrivilege::create($data);
        if ($privilege) {
            if (isset($request['roles'])) {
                foreach ($request['roles'] as $role) {
                    StorePrivilegeRole::create(['store_privilege_id' => $privilege->id, 'store_role_id' => $role]);
                }
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
        $privilege = StorePrivilege::with(['roles'])->find($id);
        $privilege_roles = $privilege->roles;
        $roles = StoreRole::all()->groupBy('group');
        return view('admin.store_privileges.update', [
            'privilege' => $privilege,
            'privilege_roles' => $privilege_roles,
            'roles' => $roles
        ]);
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
        $privilege = StorePrivilege::find($id);
        $data = array();
        if ($request['name_ar'] != null) $data['name_ar'] = $request['name_ar'];
        if ($request['name_en'] != null) $data['name_en'] = $request['name_en'];
        if ($request['is_default'] != null) $data['is_default'] = $request['is_default'];
        $privilege->update($data);
        if (isset($request['roles']) && is_array($request['roles'])) {
            StorePrivilegeRole::where('store_privilege_id', $id)->delete();
            foreach ($request['roles'] as $role) {
                StorePrivilegeRole::create(['store_privilege_id' => $id, 'store_role_id' => $role]);
            }
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
        $privilege = StorePrivilege::find($id);
        $privilege->delete();
        return back()->with(['success' => __('messages.delete_success')]);
    }
}
