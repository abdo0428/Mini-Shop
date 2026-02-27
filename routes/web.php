<?php
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\OrderAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/lang/{locale}', function (string $locale) {
    $supported = ['en', 'ar', 'tr'];
    if (!in_array($locale, $supported, true)) {
        abort(404);
    }
    session(['locale' => $locale]);
    app()->setLocale($locale);
    return redirect()->back()->with('success', __('lang.language_updated'));
})->name('lang.switch');

Route::get('/', [ShopController::class, 'landing'])->name('landing');
Route::get('/dashboard', fn() => redirect()->route('shop.index'))->name('dashboard');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/products/{product}', [ShopController::class, 'show'])->name('products.show');

// Cart
Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::get('/cart/summary', [CartController::class, 'summary'])->name('cart.summary');
Route::get('/cart/mini', [CartController::class, 'mini'])->name('cart.mini');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout + Orders (auth)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'confirm'])->name('checkout.confirm');
    Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.place');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// Admin
Route::prefix('admin')->middleware(['auth','admin'])->group(function () {
    Route::get('/products', [ProductAdminController::class, 'index'])->name('admin.products.index');
    Route::get('/products/datatable', [ProductAdminController::class, 'datatable'])->name('admin.products.datatable');
    Route::post('/products', [ProductAdminController::class, 'store'])->name('admin.products.store');
    Route::put('/products/{product}', [ProductAdminController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [ProductAdminController::class, 'destroy'])->name('admin.products.destroy');

    Route::get('/orders', [OrderAdminController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/datatable', [OrderAdminController::class, 'datatable'])->name('admin.orders.datatable');
    Route::get('/orders/{order}', [OrderAdminController::class, 'show'])->name('admin.orders.show');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
// need to uplade to github repository 