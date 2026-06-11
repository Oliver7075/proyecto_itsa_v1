<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstitutoController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Configuracion de instituto 
Route::get('/admin/instituto', [InstitutoController::class, 'index'])->name('admin.instituto.index')->middleware('auth');
Route::put('/admin/instituto', [InstitutoController::class, 'update'])->name('admin.instituto.update')->middleware('auth');
//rutas para los empleados
Route::get('/admin/empleados', [App\Http\Controllers\EmpleadoController::class, 'index'])->name('admin.empleados.index')->middleware('auth');
Route::get('/admin/empleados/create', [App\Http\Controllers\EmpleadoController::class, 'create'])->name('admin.empleados.create')->middleware('auth');
Route::post('/admin/empleados/create', [App\Http\Controllers\EmpleadoController::class, 'store'])->name('admin.empleados.store')->middleware('auth');
Route::get('/admin/empleados/{id}/edit', [App\Http\Controllers\EmpleadoController::class, 'edit'])->name('admin.empleados.edit')->middleware('auth');
Route::put('/admin/empleados/{id}', [App\Http\Controllers\EmpleadoController::class, 'update'])->name('admin.empleados.update')->middleware('auth');
Route::delete('/admin/empleados/{id}', [App\Http\Controllers\EmpleadoController::class, 'destroy'])->name('admin.empleados.destroy')->middleware('auth');
//rutas para los usuarios
Route::get('/admin/usuarios', [App\Http\Controllers\UsuarioController::class, 'index'])->name('admin.usuarios.index')->middleware('auth');
Route::get('/admin/usuarios/create', [App\Http\Controllers\UsuarioController::class, 'create'])->name('admin.usuarios.create')->middleware('auth');
Route::post('/admin/usuarios/create', [App\Http\Controllers\UsuarioController::class, 'store'])->name('admin.usuarios.store')->middleware('auth');
//rutas para las carreras
Route::get('/planes/carreras', [App\Http\Controllers\CarreraController::class, 'index'])->name('planes.carreras.index')->middleware('auth');
Route::get('/planes/carreras/create', [App\Http\Controllers\CarreraController::class, 'create'])->name('planes.carreras.create')->middleware('auth');
Route::post('/planes/carreras/create', [App\Http\Controllers\CarreraController::class, 'store'])->name('planes.carreras.store')->middleware('auth');
Route::get('/planes/carreras/{id}/edit', [App\Http\Controllers\CarreraController::class, 'edit'])->name('planes.carreras.edit')->middleware('auth');
Route::put('/planes/carreras/{id}', [App\Http\Controllers\CarreraController::class, 'update'])->name('planes.carreras.update')->middleware('auth');
Route::delete('/planes/carreras/{id}', [App\Http\Controllers\CarreraController::class, 'destroy'])->name('planes.carreras.destroy')->middleware('auth');