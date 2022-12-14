<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddon extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function addon(){
        return $this->belongsTo(Addon::class);
    }
}
