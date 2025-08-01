<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

Route::redirect('/', '/login');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});


Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    require __DIR__ . '/users.php';
    require __DIR__ . '/products.php';

    Route::prefix('estoque')->group(function () {
        Route::get('/', [App\Http\Controllers\StockController::class, 'index'])->name('stocks.index');
        Route::get('/entrada', [App\Http\Controllers\StockMovementController::class, 'createEntrada'])->name('stock_movements.create_entrada');
        Route::post('/entrada', [App\Http\Controllers\StockMovementController::class, 'storeEntrada'])->name('stock_movements.store_entrada');
        Route::get('/saida', [App\Http\Controllers\StockMovementController::class, 'createSaida'])->name('stock_movements.create_saida');
        Route::post('/saida', [App\Http\Controllers\StockMovementController::class, 'storeSaida'])->name('stock_movements.store_saida');
        Route::get('/historico', [App\Http\Controllers\StockMovementController::class, 'historico'])->name('stock_movements.historico');
    });
});
