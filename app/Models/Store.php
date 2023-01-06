<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function scopeAccepted($query)
    {
        return $query->where('status', 1);
    }
    public function users()
    {
        return $this->hasMany(UserStorePrivilege::class);
    }
    public function branches()
    {
        return $this->hasMany(Store::class, 'parent_id', 'id');
    }
    public function product_categories()
    {
        return $this->hasMany(ProductCategory::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function addonCategories()
    {
        return $this->hasMany(AddonCategory::class);
    }
    public function addons()
    {
        return $this->hasMany(Addon::class);
    }
    public function addonCategoryItems()
    {
        return $this->hasMany(AddonCategoryItem::class);
    }
    public function edits()
    {
        return $this->hasMany(Edit::class);
    }
    public function sauces()
    {
        return $this->hasMany(Sauce::class);
    }
    public function sizes()
    {
        return $this->hasMany(Size::class);
    }
    public function tables()
    {
        return $this->hasMany(Table::class);
    }
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    public function hasBranches()
    {
        if ($this->max_branches > 0) return true;
        return false;
    }
    public function parent()
    {
        return $this->belongsTo(Store::class, 'parent_id', 'id');
    }
    public function setting()
    {
        return $this->hasOne(StoreSetting::class);
    }
    public function store_invites()
    {
        return $this->hasMany(StoreInvite::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
    public function themes()
    {
        return $this->hasMany(Theme::class);
    }
    public function work_days()
    {
        return $this->hasMany(WorkDay::class);
    }
    public function country_code()
    {
        return $this->belongsTo(CountryCode::class);
    }
}
