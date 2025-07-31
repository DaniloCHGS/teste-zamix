<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

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

    Route::prefix('ususarios')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/cadastrar', [UserController::class, 'create'])->name('users.create');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::get('/{user}/editar', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::prefix('produtos')->group((function () {
        Route::get('/simples', [ProductController::class, 'simpleIndex'])->name('products.simple.index');
        Route::get('/simples/cadastrar', [ProductController::class, 'simpleCreate'])->name('products.simple.create');
        Route::post('/simples', [ProductController::class, 'simpleStore'])->name('products.simple.store');
        Route::get('/simples/{product}/editar', [ProductController::class, 'simpleEdit'])->name('products.simple.edit');
        Route::put('/simples/{product}', [ProductController::class, 'simpleUpdate'])->name('products.simple.update');
        Route::get('/simples/{product}/excluir', [ProductController::class, 'simpleDelete'])->name('products.simple.delete');
        Route::delete('/simples/{product}', [ProductController::class, 'simpleDestroy'])->name('products.simple.destroy');
    }));
});
