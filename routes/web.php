
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductCatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerOrderController;

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\ShippingServiceController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;


// Halaman Utama
Route::get('/', function () {
    return redirect()->route('login');
});


// Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// Katalog Produk
Route::get('/shop', [ProductCatalogController::class, 'index'])
    ->name('shop.index');

Route::get('/shop/{product:slug}', [ProductCatalogController::class, 'show'])
    ->name('shop.show');


// Route Admin
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Kategori
        Route::get('/categories', [CategoryController::class, 'index'])
            ->name('categories.index');

        Route::post('/categories', [CategoryController::class, 'store'])
            ->name('categories.store');

        Route::put('/categories/{category}', [CategoryController::class, 'update'])
            ->name('categories.update');

        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
            ->name('categories.destroy');

        // Produk
        Route::resource('products', ProductController::class)
            ->names('products');

        // Stok
        Route::get('/stock', [StockController::class, 'index'])
            ->name('stock.index');

        Route::get('/stock/create', [StockController::class, 'create'])
            ->name('stock.create');

        Route::post('/stock', [StockController::class, 'store'])
            ->name('stock.store');

        // Ekspedisi
        Route::get('/shipping', [ShippingServiceController::class, 'index'])
            ->name('shipping.index');

        Route::post('/shipping', [ShippingServiceController::class, 'store'])
            ->name('shipping.store');

        Route::put('/shipping/{service}', [ShippingServiceController::class, 'update'])
            ->name('shipping.update');

        Route::delete('/shipping/{service}', [ShippingServiceController::class, 'destroy'])
            ->name('shipping.destroy');

        // Transaksi Admin
        Route::get('/orders', [AdminOrderController::class, 'index'])
            ->name('orders.index');

        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])
            ->name('orders.show');

        Route::patch('/orders/{order}/confirm', [AdminOrderController::class, 'confirm'])
            ->name('orders.confirm');

        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
            ->name('orders.status');

        Route::patch('/orders/{order}/cancel', [AdminOrderController::class, 'cancel'])
            ->name('orders.cancel');
    });


// Route Pelanggan
Route::middleware(['auth', 'role:customer'])->group(function () {

    // Keranjang
    Route::get('/keranjang', [CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/keranjang/{product}', [CartController::class, 'store'])
        ->name('cart.store');

    Route::patch('/keranjang/{product}', [CartController::class, 'update'])
        ->name('cart.update');

    Route::delete('/keranjang/{product}', [CartController::class, 'destroy'])
        ->name('cart.destroy');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');

    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->name('checkout.store');

    // Riwayat Pesanan Pelanggan
    Route::get('/pesanan', [CustomerOrderController::class, 'index'])
        ->name('orders.index');

    Route::get('/pesanan/{order}', [CustomerOrderController::class, 'show'])
        ->name('orders.show');
});
