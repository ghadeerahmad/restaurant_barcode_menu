<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SitePrivilege;
use App\Models\SitePrivilegeRole;
use App\Models\SiteRole;
use App\Models\User;
use Illuminate\Http\Request;

class SitePrivilegeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        get_locale();
        $privileges = SitePrivilege::all();
        return view('admin.site_privileges.index', ['privileges' => $privileges]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        get_locale();
        $site_roles = SiteRole::get()->groupBy('group');
        return view('admin.site_privileges.create', ['roles' => $site_roles]);
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
        $privilege = SitePrivilege::create($data);
        if ($privilege) {
            if (isset($request['roles'])) {
                foreach ($request['roles'] as $role) {
                    SitePrivilegeRole::create(['site_privilege_id' => $privilege->id, 'site_role_id' => $role]);
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
        $privilege = SitePrivilege::with(['roles'])->find($id);
        $roles = SiteRole::get()->groupBy('group');
        return view('admin.site_privileges.update', [
            'privilege' => $privilege,
            'privilege_roles' => $privilege->roles,
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
        $privilege =  SitePrivilege::find($id);
        request()->validate([
            'name_ar' => 'required|max:50',
            'name_en' => 'required|max:50',
            'roles' => 'required|array'
        ]);
        $data = [
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en']
        ];
        $privilege->update($data);
        if (isset($request['roles'])) {
            SitePrivilegeRole::where('site_privilege_id', $id)->delete();
            foreach ($request['roles'] as $role) {
                SitePrivilegeRole::create(['site_privilege_id' => $privilege->id, 'site_role_id' => $role]);
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
        $privilege = SitePrivilege::find($id);
        SitePrivilegeRole::where('site_privilege_id', $id)->delete();
        $users = User::where('site_privilege_id', $id)->get();
        foreach ($users as $user) {
            $user->site_privilege_id = 0;
            $user->save();
        }
        $privilege->delete();
        return back();
    }
}
