<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSauce extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function sauce(){
        return $this->belongsTo(Sauce::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
