<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sauce extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function productSauces(){
        return $this->hasMany(ProductSauce::class);
    }
}
