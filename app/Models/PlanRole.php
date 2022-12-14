<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanRole extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function plan(){
        return $this->belongsTo(Plan::class);
    }
    public function role(){
        return $this->belongsTo(Role::class);
    }
}
