<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanOrder extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function plan(){
        return $this->belongsTo(Plan::class);
    }
    public function payment_method(){
        return $this->belongsTo(PaymentMethod::class);
    }
    public function store(){
        return $this->belongsTo(Store::class);
    }
}
