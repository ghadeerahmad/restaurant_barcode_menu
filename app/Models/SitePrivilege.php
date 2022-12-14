<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitePrivilege extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function roles(){
        return $this->hasMany(SitePrivilegeRole::class);
    }
}
