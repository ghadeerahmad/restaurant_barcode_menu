<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function store(){
        return $this->belongsTo(Store::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function addons(){
        return $this->hasMany(CartAddon::class);
    }
    public function edits(){
        return $this->hasMany(CartEdit::class);
    }
    public function sauces(){
        return $this->hasMany(CartSauce::class);
    }
    public function sizes(){
        return $this->hasMany(CartSize::class);
    }
}
