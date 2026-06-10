<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstitutoController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Configuracion de instituto 
Route::get('/admin/instituto', [InstitutoController::class, 'index'])->name('admin.instituto.index')->middleware('auth');;
Route::put('/admin/instituto', [InstitutoController::class, 'update'])->name('admin.instituto.update')->middleware('auth');;
