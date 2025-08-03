<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

Route::prefix('relatorios')->name('reports.')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('index');
    Route::get('/entradas', [ReportController::class, 'stockEntry'])->name('stock_entry');
    Route::post('/', [ReportController::class, 'gerarRelatorio'])->name('gerar');
});