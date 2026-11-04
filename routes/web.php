<?php
use App\Helpers\Router;

use App\Controllers\HomeController;
use App\Controllers\ShopController;
use App\Controllers\ProductController;
use App\Controllers\CartController;
use App\Controllers\CheckoutController;
use App\Controllers\AuthController;
use App\Controllers\AccountController;
use App\Controllers\PageController;
use App\Controllers\ApiController;

use App\Controllers\Admin\AuthController as AdminAuthController;
use App\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Controllers\Admin\ProductController as AdminProductController;
use App\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Controllers\Admin\OrderController as AdminOrderController;
use App\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Controllers\Admin\InventoryController as AdminInventoryController;
use App\Controllers\Admin\BannerController as AdminBannerController;
use App\Controllers\Admin\CouponController as AdminCouponController;
use App\Controllers\Admin\ReviewController as AdminReviewController;
use App\Controllers\Admin\CmsController as AdminCmsController;
use App\Controllers\Admin\SettingController as AdminSettingController;

// --- Frontend Routes ---
Router::get('/', [HomeController::class, 'index']);
Router::get('/search', [ShopController::class, 'search']);
Router::get('/collections/all', [ShopController::class, 'index']);
Router::get('/collections/{slug}', [ShopController::class, 'index']);
Router::get('/products/{handle}', [ProductController::class, 'show']);

// Cart
Router::get('/cart', [CartController::class, 'index']);
Router::get('/cart.js', [CartController::class, 'json']);
Router::get('/cart/json', [CartController::class, 'json']);
Router::post('/cart/add', [CartController::class, 'add']);
Router::post('/cart/add.js', [CartController::class, 'add']);
Router::post('/cart/change', [CartController::class, 'change']);
Router::post('/cart/change.js', [CartController::class, 'change']);
Router::post('/cart/apply-coupon', [CartController::class, 'applyCoupon']);

// Checkout
Router::get('/checkout', [CheckoutController::class, 'index']);
Router::post('/checkout/process', [CheckoutController::class, 'process']);
Router::get('/checkout/success', [CheckoutController::class, 'success']);
Router::post('/checkout/create-account', [CheckoutController::class, 'createAccount']);

// Customer Auth & Portal
Router::get('/account/login', [AuthController::class, 'login']);
Router::post('/account/login/submit', [AuthController::class, 'loginSubmit']);
Router::get('/account/register', [AuthController::class, 'register']);
Router::post('/account/register/submit', [AuthController::class, 'registerSubmit']);
Router::get('/account/recover', [AuthController::class, 'recover']);
Router::post('/account/recover/submit', [AuthController::class, 'recoverSubmit']);
Router::get('/account/forgot', [AuthController::class, 'recover']);
Router::post('/account/forgot/submit', [AuthController::class, 'recoverSubmit']);
Router::get('/account/forgot-password', [AuthController::class, 'recover']);
Router::post('/account/forgot-password/submit', [AuthController::class, 'recoverSubmit']);
Router::get('/forgot-password', [AuthController::class, 'recover']);
Router::post('/forgot-password/submit', [AuthController::class, 'recoverSubmit']);
Router::get('/recover', [AuthController::class, 'recover']);
Router::post('/recover/submit', [AuthController::class, 'recoverSubmit']);
Router::get('/account/reset-password', [AuthController::class, 'resetPassword']);
Router::post('/account/reset-password/submit', [AuthController::class, 'resetPasswordSubmit']);
Router::get('/account/logout', [AuthController::class, 'logout']);
Router::get('/account', [AccountController::class, 'index']);
Router::get('/account/orders/{id}', [AccountController::class, 'orderDetail']);

// Informational & Quiz Pages
Router::get('/pages/about-us', [PageController::class, 'aboutUs']);
Router::get('/pages/routine-finder', [PageController::class, 'routineFinder']);
Router::get('/pages/wishlist', [PageController::class, 'wishlist']);
Router::get('/pages/contact', [PageController::class, 'contact']);
Router::post('/pages/contact/submit', [PageController::class, 'contactSubmit']);
Router::get('/pages/{slug}', [PageController::class, 'cms']);

// API Endpoints
Router::get('/api/search', [ApiController::class, 'search']);
Router::get('/search/suggest', [ApiController::class, 'search']);
Router::get('/search/suggest.json', [ApiController::class, 'search']);
Router::post('/api/newsletter', [ApiController::class, 'newsletter']);
Router::post('/api/reviews', [ApiController::class, 'review']);

// --- Admin Control Panel Routes ---
Router::get('/admin/login', [AdminAuthController::class, 'login']);
Router::post('/admin/login/submit', [AdminAuthController::class, 'loginSubmit']);
Router::get('/admin/logout', [AdminAuthController::class, 'logout']);

Router::get('/admin', [AdminDashboardController::class, 'index']);

Router::get('/admin/products', [AdminProductController::class, 'index']);
Router::get('/admin/products/create', [AdminProductController::class, 'create']);
Router::post('/admin/products/store', [AdminProductController::class, 'store']);
Router::get('/admin/products/edit', [AdminProductController::class, 'edit']);
Router::post('/admin/products/update', [AdminProductController::class, 'update']);
Router::any('/admin/products/delete', [AdminProductController::class, 'delete']);

Router::get('/admin/categories', [AdminCategoryController::class, 'index']);
Router::post('/admin/categories/store', [AdminCategoryController::class, 'store']);

Router::get('/admin/orders', [AdminOrderController::class, 'index']);
Router::get('/admin/orders/show', [AdminOrderController::class, 'show']);
Router::post('/admin/orders/update-status', [AdminOrderController::class, 'updateStatus']);

Router::get('/admin/inventory', [AdminInventoryController::class, 'index']);
Router::post('/admin/inventory/update', [AdminInventoryController::class, 'update']);

Router::get('/admin/customers', [AdminCustomerController::class, 'index']);

Router::get('/admin/banners', [AdminBannerController::class, 'index']);
Router::post('/admin/banners/store', [AdminBannerController::class, 'store']);
Router::any('/admin/banners/delete', [AdminBannerController::class, 'delete']);

Router::get('/admin/coupons', [AdminCouponController::class, 'index']);
Router::post('/admin/coupons/store', [AdminCouponController::class, 'store']);
Router::any('/admin/coupons/delete', [AdminCouponController::class, 'delete']);

Router::get('/admin/reviews', [AdminReviewController::class, 'index']);
Router::any('/admin/reviews/approve', [AdminReviewController::class, 'approve']);
Router::any('/admin/reviews/reject', [AdminReviewController::class, 'reject']);
Router::any('/admin/reviews/delete', [AdminReviewController::class, 'delete']);

Router::get('/admin/cms', [AdminCmsController::class, 'index']);
Router::get('/admin/cms/edit', [AdminCmsController::class, 'edit']);
Router::post('/admin/cms/update', [AdminCmsController::class, 'update']);

Router::get('/admin/settings', [AdminSettingController::class, 'index']);
Router::post('/admin/settings/update', [AdminSettingController::class, 'update']);
