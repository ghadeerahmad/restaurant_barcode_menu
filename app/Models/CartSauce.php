<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartSauce extends Model
{
    use HasFactory;
    protected $gaurded = [];
    public function cart(){
        return $this->belongsTo(Cart::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function sauce(){
        return $this->belongsTo(Sauce::class);
    }
}
