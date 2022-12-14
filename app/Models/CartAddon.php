<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartAddon extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function cart(){
        return $this->belongsTo(Cart::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function addon(){
        return $this->belongsTo(Addon::class);
    }
}
