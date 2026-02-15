<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\OrdersController;

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

Route::get('/', function () {
    return redirect()->route('login');
});

// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration
Route::get('/register', function () {
    return view('register');
})->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Admin login
Route::get('/admin/login', [AdminLoginController::class, 'show'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');

// Placeholder for password reset
Route::get('/password/reset', function () {
    return view('password.reset');
})->name('password.request');

// Dashboard (protected route)
Route::get('/dashboard', function () {
    return view('dashboard_admin');
})->middleware('auth')->name('dashboard');

// Orders (protected route, from database)
Route::get('/orders', [OrdersController::class, 'index'])->middleware('auth')->name('orders');

// Products admin (static list for now)
Route::get('/admin/products', function () {
    return view('products_admin');
})->middleware('auth')->name('products.admin');

// Customers admin
Route::get('/admin/customers', function () {
    return view('customers_admin');
})->middleware('auth')->name('customers.admin');

// Analytics admin
Route::get('/admin/analytics', function () {
    return view('analytics_admin');
})->middleware('auth')->name('analytics.admin');

// Reviews admin
Route::get('/admin/reviews', function () {
    return view('reviews_admin');
})->middleware('auth')->name('reviews.admin');

// Categories admin
Route::get('/admin/categories', function () {
    return view('categories_admin');
})->middleware('auth')->name('categories.admin');

// Brands admin
Route::get('/admin/brands', function () {
    return view('brands_admin');
})->middleware('auth')->name('brands.admin');

// Revenue admin
Route::get('/admin/revenue', function () {
    return view('revenue_admin');
})->middleware('auth')->name('revenue.admin');

