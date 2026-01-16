<?php

use App\Http\Controllers\api\LocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/states/{country}', [LocationController::class, 'states']);
Route::get('/cities/{state}', [LocationController::class, 'cities']);