<?php

use App\Http\Controllers\AdminauthController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\TestController;
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

Route::middleware('guest')->group(function (){
    Route::get('register',[AuthController::class,'index'])->name('register');
    Route::post('regoster',[AuthController::class,'store'])->name('post-register');
    Route::view('login','Auth.login')->name('login');
    Route::post('login',[AuthController::class,'login'])->name('post-login');
});


Route::get('/home',[HomeController::class,'show'])->name('home');
Route::view('/contact-us','contactus.contact-us')->name('contact-us');
Route::get('/category/filter', [CategoryController::class, 'filterCategory'])->name('category.filter');
Route::get('/category/{slug}', [CategoryController::class, 'showCategory'])->name('category.show');
Route::get('/product/{slug}', [ProductDetailController::class, 'show'])->name('product.show');
Route::get('/products', [ProductDetailController::class, 'index'])->name('products.index');



Route::middleware(['auth'])->group(function (){

    Route::prefix('checkout')->group(function(){
        Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/buy', [CheckoutController::class, 'buynow'])->name('checkout.buynow');
        Route::post('/process', [CheckoutController::class, 'process'])->name('checkout.process');
    });
    
    Route::prefix('order')->group(function(){
        Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/{id}', [OrderController::class, 'show'])->name('order.details');
        Route::get('/success/{orderId}', [OrderController::class, 'success'])->name('order.success');
        Route::put('/{id}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');
    });
    
    Route::prefix('cart')->group(function(){
        Route::post('/add',[CartController::class,'add'])->name('cart.add');
        Route::get('/count', [CartController::class, 'getCount'])->name('cart.count');
        Route::get('/items', [CartController::class, 'getItems'])->name('cart.items');
        Route::post('/update', [CartController::class, 'update'])->name('cart.update');
        Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});