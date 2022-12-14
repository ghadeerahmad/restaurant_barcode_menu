<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'phone',
        'site_privilege_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function stores()
    {
        return $this->hasMany(StoreAdmin::class);
    }

    public function hasSiteRole($role)
    {
        if (auth()->user()->site_privilege_id == null) return false;
        $privilegeRoles = SitePrivilegeRole::with(['site_role'])->where('site_privilege_id', auth()->user()->site_privilege_id)->get();
        $roles = $privilegeRoles;
        foreach ($roles as $r) {
            if ($r->site_role->code == $role) return true;
        }
        return false;
    }
    public function hasStoreRole($role)
    {
        $store_id = get_current_store();
        $privilege = UserStorePrivilege::where('user_id', auth()->user()->id)
            ->where('store_id', $store_id)
            ->first();
        if ($privilege == null) return false;
        $roles = StorePrivilegeRole::with(['store_role'])->where('store_privilege_id', $privilege->store_privilege_id)->get();
        //dd($roles);
        foreach ($roles as $rl) {
            if ($rl->store_role->code == $role) return true;
        }
        return false;
    }
    public function user_store_privileges()
    {
        return $this->hasMany(UserStorePrivilege::class);
    }
    public function site_privilege()
    {
        return $this->belongsTo(SitePrivilege::class);
    }
    public function store_privilege()
    {
        $store_id = get_current_store();
        $privilege = UserStorePrivilege::where('user_id', $this->id)
            ->where('store_id', $store_id)
            ->first();
        return App::isLocale('ar') ? $privilege->store_privilege->name_ar : $privilege->store_privilege->name_en;
    }
}
