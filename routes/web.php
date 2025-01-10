<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/home', [CustomerController::class, 'Home'])->name('home');
Route::get('/allProduct', [CustomerController::class, 'getAllProduct'])->name('customer.getAllProduct');
Route::get('/productDetail/{id}', [CustomerController::class, 'getProductDetail'])->name('customer.getProductDetail');


// User Chat
Route::middleware('user')->group(function () {
    Route::get('/chat/allvendor', [ChatController::class, 'getAllVendorForChat'])->name('chat.getAllVendor');
  
    Route::get('/chat/{vendor_id}/send', [ChatController::class, 'getCustomerChat'])->name('customer.chat.get');
    Route::post('/chat/send', [ChatController::class, 'sendCustomerMessage'])->name('customer.sendMessage');   

});

// Vendor Chat
Route::prefix('vendor')->group(function(){
    Route::middleware('vendor')->group(function () {
        Route::get('/chat/{user_id}/send/', [ChatController::class, 'getVendorChat'])->name('vendor.chat.get');
        Route::post('/chat/send', [ChatController::class, 'sendVendorMessage'])->name('vendor.sendMessage');

    });
});

// User Auth Functionality
Route::prefix('customer')->group(function () {
    Route::get('/register', [AuthController::class, 'customerRegister'])->name('customer.register');
    Route::post('/register', [AuthController::class, 'customerRegisterSubmit'])->name('customer.registerSubmit');

    Route::get('/login', [AuthController::class, 'customerLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'customerLoginSubmit'])->name('customer.loginSubmit');

    Route::middleware('user')->group(function () {
        Route::any('/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');

       

        Route::post('/logout', [AuthController::class, 'customerLogout'])->name('customer.logout');
    });
});

// Pusher auth route (outside middleware to allow Pusher requests)
Route::post('/pusher/auth', [ChatController::class, 'authenticatePusher'])->name('pusher.auth');

// Vendor Functionality
Route::prefix('vendor')->group(function () {
    Route::get('/register', [AuthController::class, 'vendorRegister'])->name('vendor.register');
    Route::post('/register', [AuthController::class, 'vendorRegisterSubmit'])->name('vendor.registerSubmit');

    Route::get('/login', [AuthController::class, 'vendorLogin'])->name('vendor.login');
    Route::post('/login', [AuthController::class, 'vendorLoginSubmit'])->name('vendor.loginSubmit');

    Route::middleware('vendor')->group(function () {
        Route::any('/dashboard', [VendorController::class, 'dashboard'])->name('vendor.dashboard'); 
        Route::post('/logout', [AuthController::class, 'vendorLogout'])->name('vendor.logout');

       
        Route::any('/addProduct/{id?}',[ProductController::class, 'vendorAddProduct'])->name('vendor.addProduct');
       
    });

    //vendor product functionality


});

// Admin Functionality
Route::prefix('admin')->group(function () {
    Route::get('/register', [AuthController::class, 'adminRegister'])->name('admin.register');
    Route::post('/register', [AuthController::class, 'adminRegisterSubmit'])->name('admin.registerSubmit');

    Route::get('/login', [AuthController::class, 'adminLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'adminLoginSubmit'])->name('admin.loginSubmit');


    Route::middleware('admin')->group(function () {
        Route::any('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/logout', [AuthController::class, 'adminLogout'])->name('admin.logout');
        Route::any('/users', [AdminController::class, 'allUsers'])->name('admin.allUsers');

        // Admin Category Manage
        Route::get('/allCategory', [CategoryController::class, 'getAdminAllCategory'])->name('admin.getAllCategory');
        Route::any('/addCategory/{id?}', [CategoryController::class, 'adminAddCategory'])->name('admin.addCategory');

        // Admin size Manage
        Route::get('/allSize', [MasterController::class, 'getAllSizeByAdmin'])->name('admin.getAllSize');
        Route::any('/addSize', [MasterController::class, 'adminAddSize'])->name('admin.addSize');
    });
    
  
});
