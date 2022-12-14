<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorePrivilegeRole extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function privilege(){
        return $this->belongsTo(StorePrivilege::class);
    }
    public function store_role(){
        return $this->belongsTo(StoreRole::class);
    }
}
