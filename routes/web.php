<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\DocumentoController;
use App\Http\Middleware\RedirectIfNotAuthenticated;

Route::get('/', function () {
    /* return view('auth/login'); */
    return redirect()->route('login');
});  

Route::get('/login', [SessionsController::class, 'create'])->name('login');
Route::post('/login', [SessionsController::class, 'store'])->name('login.store');
Route::get('/logout', [SessionsController::class, 'destroy'])->name('login.destroy');

Route::get('/register', [RegisterController::class, 'create'])->name('register.index');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/home', [DocumentoController::class, 'viewHome'])->name('home.index')->middleware('auth');
Route::Post('/home', [DocumentoController::class, 'storeDocumento'])->name('home.store')->middleware('auth');

Route::get('/editarDocumento', [DocumentoController::class, 'editDocumento'])->name('home.editar')->middleware('auth');
Route::post('/editarDocumento', [DocumentoController::class, 'updateDocumento'])->name('home.update')->middleware('auth');

Route::get('/destroyDocumento', [DocumentoController::class, 'destroyDocumento'])->name('home.destroy')->middleware('auth');
Route::post('/destroyDocumento', [DocumentoController::class, 'destroyDocumento'])->name('home.destroy')->middleware('auth');
