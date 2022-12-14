<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartSize extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function cart(){
        return $this->belongsTo(Cart::class);
    }
    public function size(){
        return $this->belongsTo(Size::class);
    }
}
