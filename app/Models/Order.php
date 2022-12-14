<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function store(){
        return $this->belongsTo(Store::class);
    }
    public function order_payment(){
        return $this->hasOne(OrderPayment::class);
    }
    public function addons(){
        return $this->hasMany(OrderAddon::class);
    }
    public function edits(){
        return $this->hasMany(OrderEdit::class);
    }
    public function sauces(){
        return $this->hasMany(OrderSauce::class);
    }
    public function products(){
        return $this->hasMany(OrderProduct::class);
    }
    public function table(){
        return $this->belongsTo(Table::class);
    }
    public function sizes(){
        return $this->hasMany(OrderSize::class);
    }
}
