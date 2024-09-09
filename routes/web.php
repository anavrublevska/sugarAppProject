<?php

use App\Http\Controllers\FantomController;
use App\Http\Controllers\InsulinController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductLogController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/insulin/{insulin}', [InsulinController::class, 'destroy'])->name('insulin.destroy');
    Route::get('/insulin-edit/{insulin}', [InsulinController::class, 'edit'])->name('insulin.edit');
    Route::resource('insulins', InsulinController::class)->except(['show', 'destroy', 'edit']);
    Route::get('/product-edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
    Route::resource('products', ProductController::class)->except(['show', 'edit']);
    Route::get('product-history/{product}', [ProductLogController::class, 'productHistory'])->name('product.history');
    Route::post('calculate-nutritional-value', [ProductLogController::class, 'calculateNutritionValue'])->name('product-log.calculate-nutrition-value');
    Route::resource('product-logs', ProductLogController::class)->except(['show', 'edit']);
    Route::get('/product-log-edit/{productLog}', [ProductLogController::class, 'edit'])->name('product-log.edit');
    Route::get('/product-logs/{productLog}', [ProductLogController::class, 'show'])->name('product-log.show');
    Route::get('product-log/{productLog}/mark-successful', [ProductLogController::class, 'markSuccessful'])->name('product-log.mark-successful');
    Route::get('/fantom', [FantomController::class, 'index'])->name('fantom.index');
    Route::post('/fantom/store', [FantomController::class, 'storePoints'])->name('fantom.store-points');
    Route::delete('/fantom-point/{fantomPoint}', [FantomController::class, 'destroy'])->name('fantom-point.destroy');
});

require __DIR__.'/auth.php';
