<?php

use App\Http\Controllers\AdminauthController;
use App\Livewire\Admin\Admins\Adminindex;
use App\Livewire\Admin\Categories\CategoryIndex;
use App\Livewire\Admin\Customers\CustomerIndex;
use App\Livewire\Admin\Dashboard\Dashboard;
use App\Livewire\Admin\Orders\OrderIndex;
use App\Livewire\Admin\Product\ProductAdd;
use App\Livewire\Admin\Product\Productindex;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return redirect()->route('admin.login');
});

Route::prefix('admin')->middleware(['admin-login:login'])->group(function (){
    Route::view('login','adminV1.auth.login')->name("admin.login");
    Route::post('login-post',[AdminauthController::class,'auth'])->name("admin.login-post");
    Route::post('logout',[AdminauthController::class,'logout'])->name("admin.logout");
});

Route::prefix('admin')->middleware(['admin-login:dashboard'])->group(function (){
  
    Route::get('dashboard',Dashboard::class)->name('admin.dashboard');
    Route::get('category',CategoryIndex::class)->name('admin.category.index');
    Route::get('product',Productindex::class)->name('admin.product.index');
    Route::get('product/add',ProductAdd::class)->name('admin.product.add');
    Route::get('customers',CustomerIndex::class)->name('admin.customer.index');
    Route::get('admins',Adminindex::class)->name('admin.admins.index');
    Route::get('orders',OrderIndex::class)->name('admin.orders.index');
});

Route::view('/test','test');