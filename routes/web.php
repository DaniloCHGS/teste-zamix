<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/ususarios', [UserController::class, 'index'])->name('users.index');

    Route::get('/ususarios/cadastrar', [UserController::class, 'create'])->name('users.create');

    Route::post('/ususarios', [UserController::class, 'store'])->name('users.store');

    Route::get('/ususarios/{user}/editar', [UserController::class, 'edit'])->name('users.edit');

    Route::put('/ususarios/{user}', [UserController::class, 'update'])->name('users.update');

    Route::delete('/ususarios/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
