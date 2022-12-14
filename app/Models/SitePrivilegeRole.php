<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitePrivilegeRole extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function privilege(){
        return $this->belongsTo(Privilege::class);
    }
    public function site_role(){
        return $this->belongsTo(SiteRole::class);
    }
}
