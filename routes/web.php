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
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReturnRefundController;
use App\Http\Controllers\ReturnRefundAdminController;
use App\Http\Controllers\CouponAdminController;
use App\Http\Controllers\SellerAdminController;
use App\Http\Controllers\ProductQuestionController;
use App\Http\Controllers\ProductQAAdminController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\VoucherController;

// Public storefront
Route::get('/', [ShopController::class, 'index'])->name('shop');
Route::get('/shop', [ShopController::class, 'shop'])->name('shop.all');
Route::get('/shop/all', [ShopController::class, 'shop']);
Route::get('/categories', [ShopController::class, 'categories'])->name('categories');
Route::get('/categories/{id}', [ShopController::class, 'showCategory'])->name('categories.show');
Route::get('/product/{id}', [ShopController::class, 'showProduct'])->name('product.show');
Route::get('/product/{id}/modal', [ShopController::class, 'productModal'])->name('product.modal');
Route::get('/brands', [ShopController::class, 'brands'])->name('brands');

// Static info pages
Route::view('/faq', 'frontend.faq')->name('faq');
Route::view('/about', 'frontend.about')->name('about');
Route::view('/contact', 'frontend.contact')->name('contact');
Route::view('/shipping', 'frontend.shipping')->name('shipping');
Route::view('/trial', 'frontend.trial')->name('trial');
Route::get('/vouchers', [VoucherController::class, 'index'])->name('vouchers');
Route::post('/vouchers/activate', [VoucherController::class, 'activate'])->name('vouchers.activate');

// Cart Routes
Route::middleware(['auth', 'client'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/buy-now', [CartController::class, 'buyNow'])->name('cart.buy-now');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/count', [CartController::class, 'getCount'])->name('cart.count');

    // Notifications
    Route::get('/notifications', function() {
        return view('user.notifications');
    })->name('user.notifications');

    // Checkout Routes
    Route::middleware('verified')->group(function () {
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
        Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
        Route::post('/checkout/apply-voucher', [CheckoutController::class, 'applyVoucher'])->name('checkout.voucher');
        Route::get('/checkout/success/{order_id}', [CheckoutController::class, 'success'])->name('checkout.success');
        Route::get('/checkout/payment/callback', [CheckoutController::class, 'paymentCallback'])->name('checkout.payment.callback');
        Route::get('/order/{order_id}/track', [CheckoutController::class, 'tracking'])->name('order.track');
    });

    // Wishlists
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');

    // Product Questions
    Route::post('/product/{productId}/question', [ProductQuestionController::class, 'store'])->name('product.question.store');

    // Returns & Refunds (customer)
    Route::get('/returns', [ReturnRefundController::class, 'index'])->name('returns.index');
    Route::get('/returns/create/{orderItemId}', [ReturnRefundController::class, 'create'])->name('returns.create');
    Route::post('/returns', [ReturnRefundController::class, 'store'])->name('returns.store');

    // Reviews
    Route::post('/product/{product}/review', [ReviewController::class, 'store'])->name('review.store');
    Route::post('/review/{review}/like', [ReviewController::class, 'toggleLike'])->name('review.like');
    Route::post('/review/{review}/reply', [ReviewController::class, 'reply'])->name('review.reply');
});

// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::any('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration
Route::get('/register', function () {
    return view('register');
})->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Email Verification
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home')->with('success', 'Email successfully verified!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (\Illuminate\Http\Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Admin login
Route::get('/admin/login', [AdminLoginController::class, 'show'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');

// Password Reset
Route::get('/password/reset', [PasswordResetController::class, 'showRequestForm'])->name('password.request');
Route::post('/password/email', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [PasswordResetController::class, 'reset'])->name('password.update');

// Newsletter (public)
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Customer home (after login - for regular users)
Route::get('/home', [ShopController::class, 'index'])->middleware(['auth', 'client'])->name('home');

// Orders (protected route, for customers)
Route::get('/orders', [\App\Http\Controllers\ClientOrdersController::class, 'index'])
    ->middleware(['auth', 'client', 'verified'])
    ->name('orders');

// Profile/Account (protected route, for customers)
Route::get('/profile/edit', [\App\Http\Controllers\ProfileController::class, 'edit'])
    ->middleware(['auth', 'client', 'verified'])
    ->name('profile.edit');

Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])
    ->middleware(['auth', 'client', 'verified'])
    ->name('profile.update');

Route::post('/profile/theme', [\App\Http\Controllers\ProfileController::class, 'updateTheme'])
    ->middleware(['auth', 'client', 'verified'])
    ->name('profile.theme.update');

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

Route::patch('/admin/inventory/{id}/draft', [ProductAdminController::class, 'draft'])
    ->middleware(['auth', 'admin'])
    ->name('inventory.draft');

Route::patch('/admin/inventory/{id}/toggle-sale', [ProductAdminController::class, 'toggleSale'])
    ->middleware(['auth', 'admin'])
    ->name('products.toggle-sale');

Route::post('/admin/inventory/sale', [ProductAdminController::class, 'storeSale'])
    ->middleware(['auth', 'admin'])
    ->name('products.storeSale');

Route::patch('/admin/inventory/{id}/toggle-featured', [ProductAdminController::class, 'toggleFeatured'])
    ->middleware(['auth', 'admin'])
    ->name('products.toggle-featured');

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

Route::patch('/admin/categories/{id}/draft', [CategoryAdminController::class, 'draft'])
    ->middleware(['auth', 'admin'])
    ->name('categories.draft');

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

Route::patch('/admin/brands/{id}/draft', [BrandAdminController::class, 'draft'])
    ->middleware(['auth', 'admin'])
    ->name('brands.draft');

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

// Notifications API routes
use App\Http\Controllers\NotificationController;
Route::middleware('auth')->prefix('api/notifications')->group(function () {
    Route::get('/unread', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread');
    Route::get('/', [NotificationController::class, 'getNotifications'])->name('notifications.list');
    Route::patch('/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/{id}', [NotificationController::class, 'delete'])->name('notifications.delete');
});

// ============================================================
// RIDER ROUTES
// ============================================================

use App\Http\Controllers\RiderLoginController;
use App\Http\Controllers\RiderDashboardController;
use App\Http\Controllers\RiderAdminController;

// Rider Login (public)
Route::get('/rider/login', [RiderLoginController::class, 'show'])->name('rider.login');
Route::post('/rider/login', [RiderLoginController::class, 'login'])->name('rider.login.submit');

// Rider Dashboard (protected — rider only)
Route::middleware(['auth', 'rider'])->prefix('rider')->group(function () {
    Route::get('/dashboard', [RiderDashboardController::class, 'index'])->name('rider.dashboard');
    Route::get('/available', [RiderDashboardController::class, 'availableOrders'])->name('rider.available');
    Route::post('/accept/{id}', [RiderDashboardController::class, 'acceptOrder'])->name('rider.accept');
    Route::get('/active', [RiderDashboardController::class, 'activeDelivery'])->name('rider.active');
    Route::post('/pickup/{id}', [RiderDashboardController::class, 'pickUp'])->name('rider.pickup');
    Route::post('/deliver/{id}', [RiderDashboardController::class, 'deliver'])->name('rider.deliver');
    Route::get('/history', [RiderDashboardController::class, 'history'])->name('rider.history');
    Route::get('/products', [RiderDashboardController::class, 'products'])->name('rider.products');
});

// Admin: Riders Management
Route::middleware(['auth', 'admin'])->prefix('admin/riders')->group(function () {
    Route::get('/', [RiderAdminController::class, 'index'])->name('riders.admin');
    Route::get('/create', [RiderAdminController::class, 'create'])->name('riders.create');
    Route::post('/', [RiderAdminController::class, 'store'])->name('riders.store');
    Route::get('/{id}/edit', [RiderAdminController::class, 'edit'])->name('riders.edit');
    Route::put('/{id}', [RiderAdminController::class, 'update'])->name('riders.update');
    Route::patch('/{id}/toggle', [RiderAdminController::class, 'toggleStatus'])->name('riders.toggle');
});

// ============================================================
// ADMIN: COUPONS MANAGEMENT
// ============================================================
Route::middleware(['auth', 'admin'])->prefix('admin/coupons')->group(function () {
    Route::get('/', [CouponAdminController::class, 'index'])->name('coupons.admin');
    Route::post('/', [CouponAdminController::class, 'store'])->name('coupons.store');
    Route::put('/{id}', [CouponAdminController::class, 'update'])->name('coupons.update');
    Route::patch('/{id}/toggle', [CouponAdminController::class, 'toggleStatus'])->name('coupons.toggle');
    Route::delete('/{id}', [CouponAdminController::class, 'destroy'])->name('coupons.destroy');
});

// ============================================================
// ADMIN: SELLERS MANAGEMENT
// ============================================================
Route::middleware(['auth', 'admin'])->prefix('admin/sellers')->group(function () {
    Route::get('/', [SellerAdminController::class, 'index'])->name('sellers.admin');
    Route::post('/', [SellerAdminController::class, 'store'])->name('sellers.store');
    Route::put('/{id}', [SellerAdminController::class, 'update'])->name('sellers.update');
    Route::patch('/{id}/toggle', [SellerAdminController::class, 'toggleStatus'])->name('sellers.toggle');
    Route::post('/payout', [SellerAdminController::class, 'processPayout'])->name('sellers.payout');
});

// ============================================================
// ADMIN: PRODUCT Q&A
// ============================================================
Route::middleware(['auth', 'admin'])->prefix('admin/qa')->group(function () {
    Route::get('/', [ProductQAAdminController::class, 'index'])->name('qa.admin');
    Route::post('/{id}/answer', [ProductQAAdminController::class, 'answer'])->name('qa.answer');
});

// ============================================================
// ADMIN: RETURNS & REFUNDS
// ============================================================
Route::middleware(['auth', 'admin'])->prefix('admin/returns')->group(function () {
    Route::get('/', [ReturnRefundAdminController::class, 'index'])->name('returns.admin');
    Route::post('/{id}/approve', [ReturnRefundAdminController::class, 'approve'])->name('returns.approve');
    Route::post('/{id}/reject', [ReturnRefundAdminController::class, 'reject'])->name('returns.reject');
});

// ============================================================
// SSE (Server-Sent Events) ROUTES
// ============================================================
use App\Http\Controllers\SSEController;
Route::middleware('auth')->group(function () {
    Route::get('/api/sse/user-stream', [SSEController::class, 'userStream'])->name('sse.user-stream');
    Route::get('/api/sse/admin-stream', [SSEController::class, 'adminStream'])->name('sse.admin-stream');
});

// ============================================================
// SUPPORT CHAT ROUTES
// ============================================================
use App\Http\Controllers\SupportChatController;

// User chat routes
Route::middleware('auth')->prefix('api/support-chat')->group(function () {
    Route::post('/send', [SupportChatController::class, 'sendMessage'])->name('support-chat.send');
    Route::get('/messages', [SupportChatController::class, 'getMessages'])->name('support-chat.messages');
    Route::get('/unread-count', [SupportChatController::class, 'getUnreadCount'])->name('support-chat.unread');
    Route::post('/typing', [SupportChatController::class, 'sendTyping'])->name('support-chat.typing');
});

// Admin chat routes
Route::middleware(['auth', 'admin'])->prefix('admin/api/support-chat')->group(function () {
    Route::get('/conversations', [SupportChatController::class, 'adminGetConversations'])->name('admin.support-chat.conversations');
    Route::get('/messages/{userId}', [SupportChatController::class, 'adminGetMessages'])->name('admin.support-chat.messages');
    Route::post('/reply/{userId}', [SupportChatController::class, 'adminSendReply'])->name('admin.support-chat.reply');
    Route::post('/typing/{userId}', [SupportChatController::class, 'adminSendTyping'])->name('admin.support-chat.typing');
    Route::get('/unread-count', [SupportChatController::class, 'adminUnreadCount'])->name('admin.support-chat.unread');
});

// Admin chat page
Route::middleware(['auth', 'admin'])->get('/admin/support-chat', function () {
    return view('admin_support_chat');
})->name('admin.support-chat');

