<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderSize extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function size(){
        return $this->belongsTo(Size::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
