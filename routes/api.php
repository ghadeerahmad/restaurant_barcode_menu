<?php

use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('stores', StoreController::class);
Route::get('products', ProductController::class);
