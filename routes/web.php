
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\ShippingServiceController;
use App\Http\Controllers\ProductCatalogController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'role:admin'])
  ->name('admin.dashboard');

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

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

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
    });

        Route::get('/', [ProductCatalogController::class, 'index'])->name('shop.index'); 
        Route::get('/produk/{product:slug}', [ProductCatalogController::class, 'show'])->name('shop.show'); 

    Route::get('/shop', function () {
    return view('shop.index');
})->name('shop.index');

    Route::get('/shop', [ProductCatalogController::class, 'index'])
    ->name('shop.index');
    Route::get('/shop/{product:slug}', [ProductCatalogController::class, 'show'])
    ->name('shop.show');

