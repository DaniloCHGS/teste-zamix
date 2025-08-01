<?php

use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;

Route::prefix('requisicoes')->group(function () {
    Route::get('/', [RequestController::class, 'index'])->name('requests.index');
    Route::get('/cadastrar', [RequestController::class, 'create'])->name('requests.create');
    Route::post('/', [RequestController::class, 'store'])->name('requests.store');
    Route::get('/{request}', [RequestController::class, 'show'])->name('requests.show');
    Route::get('/{request}/editar', [RequestController::class, 'edit'])->name('requests.edit');
    Route::put('/{request}', [RequestController::class, 'update'])->name('requests.update');
    Route::get('/{request}/excluir', [RequestController::class, 'delete'])->name('requests.delete');
    Route::delete('/{request}', [RequestController::class, 'destroy'])->name('requests.destroy');
});