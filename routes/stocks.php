<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockMovementController;

Route::prefix('estoque')->group(function () {
    Route::get('/', [StockController::class, 'index'])->name('stocks.index');
    Route::get('/entrada', [StockMovementController::class, 'createEntrada'])->name('stock_movements.create_entrada');
    Route::post('/entrada', [StockMovementController::class, 'storeEntrada'])->name('stock_movements.store_entrada');
    Route::get('/saida', [StockMovementController::class, 'createSaida'])->name('stock_movements.create_saida');
    Route::post('/saida', [StockMovementController::class, 'storeSaida'])->name('stock_movements.store_saida');
    Route::get('/historico', [StockMovementController::class, 'historico'])->name('stock_movements.historico');
});