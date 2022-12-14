<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Plan;
use App\Models\PlanOrder;
use App\Models\PlanRole;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Settings;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        get_locale();
        $plans = Plan::with(['plan_roles', 'currency'])->get();
        return view('admin.plans.index', ['plans' => $plans]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        get_locale();
        $settings = Setting::where('key', 'currency_id')->first();
        $curreny = Currency::where('id', $settings->value)->first();
        $roles = Role::all();
        return view('admin.plans.add', [
            'currency' => $curreny,
            'roles' => $roles
        ]);
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
        $data = request()->validate([
            'name_ar' => 'required|max:50',
            'name_en' => 'required|max:50',
            'description_ar' => 'required|max:255',
            'description_en' => 'required|max:255',
            'price' => 'required',
            'period' => 'required',
            'max_branches' => 'nullable'
        ]);
        if ($request['is_default'] != null) $data['is_default'] = $request['is_default'];
        if ($request['is_default'] == 1) {
            $plan = Plan::where('is_default', 1)->first();
            if ($plan != null) {
                return back()->withErrors(['errors' => __('messages.there_is_default_plan')]);
            }
        }
        $settings = Setting::where('key', 'currency_id')->first();
        $data['currency_id'] = $settings->value;
        $plan = Plan::create($data);
        if ($plan) {
            if (isset($request['roles'])) {
                foreach ($request['roles'] as $role) {
                    PlanRole::create(['role_id' => $role, 'plan_id' => $plan->id]);
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
        $settings = Setting::where('key', 'currency_id')->first();
        $curreny = Currency::where('id', $settings->value)->first();
        $roles = Role::all();
        $plan = Plan::with(['plan_roles'])->find($id);
        return view('admin.plans.update', [
            'currency' => $curreny,
            'roles' => $roles,
            'plan' => $plan
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
        $plan = Plan::find($id);
        $data = request()->validate([
            'name_ar' => 'required|max:50',
            'name_en' => 'required|max:50',
            'description_ar' => 'required|max:255',
            'description_en' => 'required|max:255',
            'price' => 'required',
            'period' => 'required',
            'max_branches' => 'nullable'
        ]);
        if ($request['is_default'] != null) $data['is_default'] = $request['is_default'];
        if ($request['is_default'] == 1) {
            $pln = Plan::where('is_default', 1)->first();
            if ($pln != null && $plan->id != $pln->id) {
                return back()->withErrors(['errors' => __('messages.there_is_default_plan')]);
            }
        }
        $settings = Setting::where('key', 'currency_id')->first();
        $data['currency_id'] = $settings->value;
        $plan->update($data);
        PlanRole::where('plan_id', $id)->delete();
        if (isset($request['roles'])) {
            foreach ($request['roles'] as $role) {
                PlanRole::create(['role_id' => $role, 'plan_id' => $plan->id]);
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
        $plan = Plan::with(['stores'])->find($id);
        if (count($plan->stores) > 0)
            return back()->withErrors(['errors' => __('messages.plan_delete_error')]);
        $plan->delete();
        return back()->with(['success' => __('messages.delete_success')]);
    }
}
