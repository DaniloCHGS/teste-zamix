<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

Route::prefix('relatorios')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('relatorios.index');
    Route::post('/', [ReportController::class, 'gerarRelatorio'])->name('relatorios.gerar');
});