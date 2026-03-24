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
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AnalyticsAdminController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\DashboardController;

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

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

// Public storefront
Route::get('/', [ShopController::class, 'index'])->name('shop');
Route::get('/shop', [ShopController::class, 'shop'])->name('shop.all');
Route::get('/shop/all', [ShopController::class, 'shop']);
Route::get('/categories', [ShopController::class, 'categories'])->name('categories');
Route::get('/categories/{id}', [ShopController::class, 'showCategory'])->name('categories.show');
Route::get('/product/{id}', [ShopController::class, 'showProduct'])->name('product.show');
Route::get('/brands', [ShopController::class, 'brands'])->name('brands');

// Static info pages
Route::view('/faq', 'frontend.faq')->name('faq');
Route::view('/about', 'frontend.about')->name('about');
Route::view('/contact', 'frontend.contact')->name('contact');
Route::view('/shipping', 'frontend.shipping')->name('shipping');
Route::view('/trial', 'frontend.trial')->name('trial');

// Cart Routes
Route::middleware(['auth', 'client'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/count', [CartController::class, 'getCount'])->name('cart.count');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/checkout/apply-voucher', [CheckoutController::class, 'applyVoucher'])->name('checkout.voucher');
    Route::get('/checkout/success/{order_id}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/order/{order_id}/track', [CheckoutController::class, 'tracking'])->name('order.track');

    // Reviews
    Route::post('/product/{product}/review', [ReviewController::class, 'store'])->name('review.store');
    Route::post('/review/{review}/like', [ReviewController::class, 'toggleLike'])->name('review.like');
    Route::post('/review/{review}/reply', [ReviewController::class, 'reply'])->name('review.reply');
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
Route::get('/home', [ShopController::class, 'index'])->middleware(['auth', 'client'])->name('home');

// Orders (protected route, for customers)
Route::get('/orders', [\App\Http\Controllers\ClientOrdersController::class, 'index'])
    ->middleware(['auth', 'client'])
    ->name('orders');

// Profile/Account (protected route, for customers)
Route::get('/profile/edit', [\App\Http\Controllers\ProfileController::class, 'edit'])
    ->middleware(['auth', 'client'])
    ->name('profile.edit');

Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])
    ->middleware(['auth', 'client'])
    ->name('profile.update');

// Admin orders (admin-only view)
Route::get('/admin/orders', [OrdersController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('admin.orders');

// Admin routes (dashboard and all admin pages - admin only)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'admin'])->name('dashboard');

Route::get('/admin/api/dashboard-chart', [DashboardController::class, 'chartData'])
    ->middleware(['auth', 'admin'])->name('admin.chart');

// Read-only Products View
Route::get('/admin/products', [ProductAdminController::class, 'readOnlyIndex'])
    ->middleware(['auth', 'admin'])
    ->name('products.readonly');

// inventory CRUD (formerly products)
Route::get('/admin/inventory', [ProductAdminController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('inventory.admin');

Route::get('/admin/inventory/create', [ProductAdminController::class, 'create'])
    ->middleware(['auth', 'admin'])
    ->name('inventory.create');

Route::post('/admin/inventory', [ProductAdminController::class, 'store'])
    ->middleware(['auth', 'admin'])
    ->name('inventory.store');

Route::get('/admin/inventory/{id}/edit', [ProductAdminController::class, 'edit'])
    ->middleware(['auth', 'admin'])
    ->name('inventory.edit');

Route::put('/admin/inventory/{id}', [ProductAdminController::class, 'update'])
    ->middleware(['auth', 'admin'])
    ->name('inventory.update');

Route::delete('/admin/inventory/{id}', [ProductAdminController::class, 'destroy'])
    ->middleware(['auth', 'admin'])
    ->name('inventory.destroy');

Route::get('/admin/customers', [CustomerAdminController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('customers.admin');

Route::get('/admin/analytics', [AnalyticsAdminController::class, 'index'])
    ->middleware(['auth', 'admin', 'admin.role:main_admin,supervisor'])
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

Route::put('/admin/categories/{id}', [CategoryAdminController::class, 'update'])
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

Route::put('/admin/brands/{id}', [BrandAdminController::class, 'update'])
    ->middleware(['auth', 'admin'])
    ->name('brands.update');

Route::delete('/admin/brands/{id}', [BrandAdminController::class, 'destroy'])
    ->middleware(['auth', 'admin'])
    ->name('brands.destroy');

Route::get('/admin/revenue', [RevenueAdminController::class, 'index'])
    ->middleware(['auth', 'admin', 'admin.role:main_admin'])
    ->name('revenue.admin');

// Admin settings page
Route::get('/admin/settings', [\App\Http\Controllers\SettingsAdminController::class, 'index'])
    ->middleware(['auth', 'admin', 'admin.role:main_admin'])->name('settings.admin');
Route::post('/admin/settings', [\App\Http\Controllers\SettingsAdminController::class, 'update'])
    ->middleware(['auth', 'admin', 'admin.role:main_admin'])->name('settings.admin.update');

// Admin account requests (requires logged-in admin)
use App\Http\Controllers\AdminRequestController;
Route::get('/admin/requests', [AdminRequestController::class, 'index'])
    ->middleware(['auth', 'admin', 'admin.role:main_admin'])
    ->name('admin.requests');
Route::post('/admin/requests/{id}/approve', [AdminRequestController::class, 'approve'])
    ->middleware(['auth', 'admin', 'admin.role:main_admin'])
    ->name('admin.requests.approve');
Route::post('/admin/requests/{id}/decline', [AdminRequestController::class, 'decline'])
    ->middleware(['auth', 'admin', 'admin.role:main_admin'])
    ->name('admin.requests.decline');

// Admin users management
use App\Http\Controllers\AdminUserController;

Route::get('/admin/users', [AdminUserController::class, 'index'])
    ->middleware(['auth', 'admin', 'admin.role:main_admin,supervisor'])
    ->name('admin.users');

Route::get('/admin/users/create', [AdminUserController::class, 'create'])
    ->middleware(['auth', 'admin', 'admin.role:main_admin,supervisor'])
    ->name('admin.users.create');

Route::post('/admin/users', [AdminUserController::class, 'store'])
    ->middleware(['auth', 'admin', 'admin.role:main_admin,supervisor'])
    ->name('admin.users.store');

Route::get('/admin/users/{id}/edit', [AdminUserController::class, 'edit'])
    ->middleware(['auth', 'admin', 'admin.role:main_admin,supervisor'])
    ->name('admin.users.edit');

Route::post('/admin/users/{id}', [AdminUserController::class, 'update'])
    ->middleware(['auth', 'admin', 'admin.role:main_admin,supervisor'])
    ->name('admin.users.update');

// Admin profile
Route::get('/admin/profile', [AdminUserController::class, 'profile'])
    ->middleware(['auth', 'admin'])
    ->name('admin.profile');

Route::post('/admin/profile', [AdminUserController::class, 'profileUpdate'])
    ->middleware(['auth', 'admin'])
    ->name('admin.profile.update');

// Animal Types AJAX API
use App\Http\Controllers\AnimalTypeController;
Route::middleware(['auth', 'admin'])->prefix('admin/api/animal-types')->group(function () {
    Route::get('/', [AnimalTypeController::class, 'index'])->name('animal-types.index');
    Route::post('/', [AnimalTypeController::class, 'store'])->name('animal-types.store');
    Route::put('/{id}', [AnimalTypeController::class, 'update'])->name('animal-types.update');
    Route::delete('/{id}', [AnimalTypeController::class, 'destroy'])->name('animal-types.destroy');
    Route::patch('/{id}/status', [AnimalTypeController::class, 'toggleStatus'])->name('animal-types.toggle-status');
});

