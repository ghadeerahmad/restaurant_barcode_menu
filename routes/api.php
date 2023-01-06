<?php

use App\Http\Controllers\api\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('stores', StoreController::class);
