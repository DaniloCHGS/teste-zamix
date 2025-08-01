<?php

use App\Http\Controllers\ProductCompositeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::prefix('produtos')->group((function () {
    Route::prefix('simples')->group(function () {
        Route::get('/', [ProductController::class, 'simpleIndex'])->name('products.simple.index');
        Route::get('/cadastrar', [ProductController::class, 'simpleCreate'])->name('products.simple.create');
        Route::post('/', [ProductController::class, 'simpleStore'])->name('products.simple.store');
        Route::get('/{product}/editar', [ProductController::class, 'simpleEdit'])->name('products.simple.edit');
        Route::put('/{product}', [ProductController::class, 'simpleUpdate'])->name('products.simple.update');
        Route::get('/{product}/excluir', [ProductController::class, 'simpleDelete'])->name('products.simple.delete');
        Route::delete('/{product}', [ProductController::class, 'simpleDestroy'])->name('products.simple.destroy');
    });

    Route::prefix('compostos')->group(function () {
        Route::get('/', [ProductCompositeController::class, 'index'])->name('products.composite.index');

        Route::get('/cadastrar', [ProductCompositeController::class, 'create'])->name('products.composite.create');
        Route::post('/', [ProductCompositeController::class, 'store'])->name('products.composite.store');
        Route::get('/{product}/editar', [ProductCompositeController::class, 'edit'])->name('products.composite.edit');
        Route::put('/{product}', [ProductCompositeController::class, 'update'])->name('products.composite.update');
        Route::get('/{product}/excluir', [ProductCompositeController::class, 'delete'])->name('products.composite.delete');
        Route::delete('/{product}', [ProductCompositeController::class, 'destroy'])->name('products.composite.destroy');
    });
}));
