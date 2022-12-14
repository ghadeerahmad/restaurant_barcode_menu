<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStorePrivilege extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function store_privilege(){
        return $this->belongsTo(StorePrivilege::class);
    }
    public function store(){
        return $this->belongsTo(Store::class);
    }
}
