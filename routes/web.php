<?php

use App\Http\Controllers\AdminauthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->middleware(['admin-login:login'])->group(function (){
    Route::view('login','adminV1.auth.login')->name("admin.login");
    Route::post('login-post',[AdminauthController::class,'auth'])->name("admin.login-post");
    Route::post('logout',[AdminauthController::class,'logout'])->name("admin.logout");
});

Route::prefix('admin')->middleware(['admin-login:dashboard'])->group(function (){
  
    Route::view('dashboard','adminV1.dashboard')->name('admin.dashboard');
});

Route::view('/test','test');