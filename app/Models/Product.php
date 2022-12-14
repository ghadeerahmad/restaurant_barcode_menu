<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function product_category(){
        return $this->belongsTo(ProductCategory::class);
    }
    public function store(){
        return $this->belongsTo(Store::class);
    }
    public function product_addons(){
        return $this->hasMany(ProductAddon::class);
    }
    public function product_edits(){
        return $this->hasMany(ProductEdit::class);
    }
    public function product_sauces(){
        return $this->hasMany(ProductSauce::class);
    }
    public function product_sizes(){
        return $this->hasMany(ProductSize::class);
    }
}
