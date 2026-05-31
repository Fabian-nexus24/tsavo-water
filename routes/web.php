<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboard;
use App\Http\Controllers\Customer\ProductController as CustomerProduct;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\OrderController as CustomerOrder;
use App\Http\Controllers\Customer\ProfileController as CustomerProfile;
use App\Http\Controllers\Driver\DashboardController as DriverDashboard;
use App\Http\Controllers\Driver\DeliveryController;
use App\Http\Controllers\Driver\ProfileController as DriverProfile;
use App\Http\Controllers\Driver\Auth\LoginController as DriverLogin;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\ProductController as AdminProduct;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrder;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\DeliveryZoneController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLogin;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [HomeController::class, 'products'])->name('public.products');
Route::get('/contact', [HomeController::class, 'contact'])->name('public.contact');
Route::get('/about', [HomeController::class, 'about'])->name('public.about');

/*
|--------------------------------------------------------------------------
| Customer Routes (Auth via Laravel Breeze)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'customer'])->prefix('customer')->name('customer.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [CustomerDashboard::class, 'index'])->name('dashboard');

    // Products
    Route::get('/products', [CustomerProduct::class, 'index'])->name('products.index');
    Route::get('/products/{slug}', [CustomerProduct::class, 'show'])->name('products.show');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::post('/checkout/mpesa-stk', [CheckoutController::class, 'stkPush'])->name('checkout.mpesa');

    // Orders
    Route::get('/orders', [CustomerOrder::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [CustomerOrder::class, 'show'])->name('orders.show');

    // Profile
    Route::get('/profile', [CustomerProfile::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [CustomerProfile::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [CustomerProfile::class, 'updatePassword'])->name('profile.password');
});

/*
|--------------------------------------------------------------------------
| Driver Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'driver'])->prefix('driver')->name('driver.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DriverDashboard::class, 'index'])->name('dashboard');
    Route::patch('/availability', [DriverDashboard::class, 'updateAvailability'])->name('availability');

    // Deliveries
    Route::get('/deliveries', [DeliveryController::class, 'index'])->name('deliveries.index');
    Route::get('/deliveries/{delivery}', [DeliveryController::class, 'show'])->name('deliveries.show');
    Route::patch('/deliveries/{delivery}/accept', [DeliveryController::class, 'accept'])->name('deliveries.accept');
    Route::patch('/deliveries/{delivery}/pickup', [DeliveryController::class, 'markPickedUp'])->name('deliveries.pickup');
    Route::patch('/deliveries/{delivery}/deliver', [DeliveryController::class, 'markDelivered'])->name('deliveries.deliver');
    Route::patch('/deliveries/{delivery}/fail', [DeliveryController::class, 'markFailed'])->name('deliveries.fail');

    // Profile
    Route::get('/profile', [DriverProfile::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [DriverProfile::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Analytics & Finance
    Route::get('/analytics', [App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics');

    // Products
    Route::resource('products', AdminProduct::class);

    // Categories
    Route::resource('categories', CategoryController::class)->except(['create', 'show', 'edit']);

    // Orders
    Route::get('/orders', [AdminOrder::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrder::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/invoice', [AdminOrder::class, 'invoice'])->name('orders.invoice');
    Route::patch('/orders/{order}/status', [AdminOrder::class, 'updateStatus'])->name('orders.status');
    Route::patch('/orders/{order}/assign-driver', [AdminOrder::class, 'assignDriver'])->name('orders.assign');
    Route::patch('/orders/{order}/cancel', [AdminOrder::class, 'cancel'])->name('orders.cancel');

    // Customers
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{user}', [CustomerController::class, 'show'])->name('customers.show');
    Route::patch('/customers/{user}/status', [CustomerController::class, 'updateStatus'])->name('customers.status');

    // Drivers
    Route::get('/drivers', [DriverController::class, 'index'])->name('drivers.index');
    Route::get('/drivers/create', [DriverController::class, 'create'])->name('drivers.create');
    Route::post('/drivers', [DriverController::class, 'store'])->name('drivers.store');
    Route::get('/drivers/{driver}', [DriverController::class, 'show'])->name('drivers.show');
    Route::get('/drivers/{driver}/edit', [DriverController::class, 'edit'])->name('drivers.edit');
    Route::put('/drivers/{driver}', [DriverController::class, 'update'])->name('drivers.update');
    Route::patch('/drivers/{driver}/status', [DriverController::class, 'updateStatus'])->name('drivers.status');

    // Delivery Zones
    Route::resource('zones', DeliveryZoneController::class)->except(['create', 'show', 'edit']);

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/deliveries', [ReportController::class, 'deliveries'])->name('reports.deliveries');
    Route::get('/reports/products', [ReportController::class, 'products'])->name('reports.products');
    Route::get('/reports/export/{type}', [ReportController::class, 'export'])->name('reports.export');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
});

/*
|--------------------------------------------------------------------------
| Breeze Auth Routes (for customers)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
