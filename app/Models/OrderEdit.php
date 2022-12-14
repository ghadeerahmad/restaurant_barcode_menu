<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderEdit extends Model
{
    use HasFactory;
    protected $guraded=[];
    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function edit(){
        return $this->belongsTo(Edit::class);
    }
}
