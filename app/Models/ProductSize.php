<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function size(){
        return $this->belongsTo(Size::class);
    }
}
