<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductEdit extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function edit(){
        return $this->belongsTo(Edit::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
