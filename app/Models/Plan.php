<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function plan_roles(){
        return $this->hasMany(PlanRole::class);
    }
    public function stores(){
        return $this->hasMany(Store::class);
    }
    public function currency(){
        return $this->belongsTo(Currency::class);
    }
    public function hasRole($role){
        $roles = $this->plan_roles;
        foreach($roles as $rl)
            if($rl->role->code == $role)
                return true;
        return false;
    }
}
