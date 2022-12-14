<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function store(){
        return $this->belongsTo(Store::class);
    }
    public function productAddons(){
        return $this->hasMany(ProductAddon::class);
    }
}
