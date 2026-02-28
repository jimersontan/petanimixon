<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductAdminController;
use App\Http\Controllers\CustomerAdminController;
use App\Http\Controllers\CategoryAdminController;
use App\Http\Controllers\ReviewAdminController;
use App\Http\Controllers\BrandAdminController;
use App\Http\Controllers\RevenueAdminController;
use App\Http\Controllers\AnalyticsAdminController;

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

// Customer home (after login - for regular users)
Route::get('/home', function () {
    return view('user_dashboard');
})->middleware('auth')->name('home');

// Orders (protected route, for customers)
Route::get('/orders', [OrdersController::class, 'index'])->middleware('auth')->name('orders');

// Admin routes (dashboard and all admin pages - admin only)
Route::get('/dashboard', function () {
    return view('dashboard_admin');
})->middleware(['auth', 'admin'])->name('dashboard');

Route::get('/admin/products', [ProductAdminController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('products.admin');

// product CRUD
Route::get('/admin/products/create', [ProductAdminController::class, 'create'])
    ->middleware(['auth', 'admin'])
    ->name('products.create');

Route::post('/admin/products', [ProductAdminController::class, 'store'])
    ->middleware(['auth', 'admin'])
    ->name('products.store');

Route::get('/admin/products/{id}/edit', [ProductAdminController::class, 'edit'])
    ->middleware(['auth', 'admin'])
    ->name('products.edit');

Route::post('/admin/products/{id}', [ProductAdminController::class, 'update'])
    ->middleware(['auth', 'admin'])
    ->name('products.update');

Route::delete('/admin/products/{id}', [ProductAdminController::class, 'destroy'])
    ->middleware(['auth', 'admin'])
    ->name('products.destroy');

Route::get('/admin/customers', [CustomerAdminController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('customers.admin');

Route::get('/admin/analytics', [AnalyticsAdminController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('analytics.admin');

Route::get('/admin/reviews', [ReviewAdminController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('reviews.admin');

Route::get('/admin/categories', [CategoryAdminController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('categories.admin');

// category CRUD
Route::get('/admin/categories/create', [CategoryAdminController::class, 'create'])
    ->middleware(['auth', 'admin'])
    ->name('categories.create');

Route::post('/admin/categories', [CategoryAdminController::class, 'store'])
    ->middleware(['auth', 'admin'])
    ->name('categories.store');

Route::get('/admin/categories/{id}/edit', [CategoryAdminController::class, 'edit'])
    ->middleware(['auth', 'admin'])
    ->name('categories.edit');

Route::post('/admin/categories/{id}', [CategoryAdminController::class, 'update'])
    ->middleware(['auth', 'admin'])
    ->name('categories.update');

Route::delete('/admin/categories/{id}', [CategoryAdminController::class, 'destroy'])
    ->middleware(['auth', 'admin'])
    ->name('categories.destroy');

Route::get('/admin/brands', [BrandAdminController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('brands.admin');

// brand CRUD
Route::get('/admin/brands/create', [BrandAdminController::class, 'create'])
    ->middleware(['auth', 'admin'])
    ->name('brands.create');

Route::post('/admin/brands', [BrandAdminController::class, 'store'])
    ->middleware(['auth', 'admin'])
    ->name('brands.store');

Route::get('/admin/brands/{id}/edit', [BrandAdminController::class, 'edit'])
    ->middleware(['auth', 'admin'])
    ->name('brands.edit');

Route::post('/admin/brands/{id}', [BrandAdminController::class, 'update'])
    ->middleware(['auth', 'admin'])
    ->name('brands.update');

Route::delete('/admin/brands/{id}', [BrandAdminController::class, 'destroy'])
    ->middleware(['auth', 'admin'])
    ->name('brands.destroy');

Route::get('/admin/revenue', [RevenueAdminController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('revenue.admin');

// Admin settings page
Route::get('/admin/settings', function () {
    return view('admin_settings');
})->middleware(['auth', 'admin'])->name('settings.admin');
// placeholder POST route for updates
Route::post('/admin/settings', function () {
    // handle settings form submission
    return back();
})->middleware(['auth', 'admin'])->name('settings.admin.update');

// Admin users management
use App\Http\Controllers\AdminUserController;

Route::get('/admin/users', [AdminUserController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('admin.users');

Route::get('/admin/users/create', [AdminUserController::class, 'create'])
    ->middleware(['auth', 'admin'])
    ->name('admin.users.create');

Route::post('/admin/users', [AdminUserController::class, 'store'])
    ->middleware(['auth', 'admin'])
    ->name('admin.users.store');

Route::get('/admin/users/{id}/edit', [AdminUserController::class, 'edit'])
    ->middleware(['auth', 'admin'])
    ->name('admin.users.edit');

Route::post('/admin/users/{id}', [AdminUserController::class, 'update'])
    ->middleware(['auth', 'admin'])
    ->name('admin.users.update');

// Admin profile
Route::get('/admin/profile', [AdminUserController::class, 'profile'])
    ->middleware(['auth', 'admin'])
    ->name('admin.profile');

Route::post('/admin/profile', [AdminUserController::class, 'profileUpdate'])
    ->middleware(['auth', 'admin'])
    ->name('admin.profile.update');

