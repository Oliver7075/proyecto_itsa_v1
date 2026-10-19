<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InstitutoController;
use App\Http\Controllers\RecursoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\AsignacionDocenteController;
use App\Http\Controllers\GestionAcademicaController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\MateriaController;

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
Route::get('/admin/usuarios', [App\Http\Controllers\UserController::class, 'index'])->name('admin.usuarios.index')->middleware('auth');
Route::get('/admin/usuarios/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('admin.usuarios.edit')->middleware('auth');
Route::put('/admin/usuarios/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('admin.usuarios.update')->middleware('auth');
Route::post('/admin/usuarios/{id}/regenerar-credenciales', [App\Http\Controllers\UserController::class, 'regenerarCredenciales'])->name('admin.usuarios.regenerar-credenciales')->middleware('auth');
//rutas para los roles
Route::get('/admin/roles', [RolController::class, 'index'])->name('admin.roles.index')->middleware('auth');
Route::get('/admin/roles/create', [RolController::class, 'create'])->name('admin.roles.create')->middleware('auth');
Route::post('/admin/roles/create', [RolController::class, 'store'])->name('admin.roles.store')->middleware('auth');
Route::get('/admin/roles/{id}/edit', [RolController::class, 'edit'])->name('admin.roles.edit')->middleware('auth');
Route::put('/admin/roles/{id}', [RolController::class, 'update'])->name('admin.roles.update')->middleware('auth');
Route::delete('/admin/roles/{id}', [RolController::class, 'destroy'])->name('admin.roles.destroy')->middleware('auth');
//rutas para los recursos
Route::get('/admin/recursos', [RecursoController::class, 'index'])->name('admin.recursos.index')->middleware('auth');
Route::get('/admin/recursos/create', [RecursoController::class, 'create'])->name('admin.recursos.create')->middleware('auth');
Route::post('/admin/recursos/create', [RecursoController::class, 'store'])->name('admin.recursos.store')->middleware('auth');
//rutas para las carreras
Route::get('/planes/carreras', [App\Http\Controllers\CarreraController::class, 'index'])->name('planes.carreras.index')->middleware('auth');
Route::get('/planes/carreras/create', [App\Http\Controllers\CarreraController::class, 'create'])->name('planes.carreras.create')->middleware('auth');
Route::post('/planes/carreras/create', [App\Http\Controllers\CarreraController::class, 'store'])->name('planes.carreras.store')->middleware('auth');
Route::get('/planes/carreras/{id}/materias/import', [MateriaController::class, 'importForm'])->name('planes.carreras.materias.import')->middleware('auth');
Route::post('/planes/carreras/{id}/materias/import', [MateriaController::class, 'import'])->name('planes.carreras.materias.import.store')->middleware('auth');
Route::get('/planes/carreras/{id}/edit', [App\Http\Controllers\CarreraController::class, 'edit'])->name('planes.carreras.edit')->middleware('auth');
Route::put('/planes/carreras/{id}', [App\Http\Controllers\CarreraController::class, 'update'])->name('planes.carreras.update')->middleware('auth');
Route::delete('/planes/carreras/{id}', [App\Http\Controllers\CarreraController::class, 'destroy'])->name('planes.carreras.destroy')->middleware('auth');
//rutas para materias y prerequisitos
Route::get('/planes/materias', [MateriaController::class, 'index'])->name('planes.materias.index')->middleware('auth');
Route::get('/planes/materias/create', [MateriaController::class, 'create'])->name('planes.materias.create')->middleware('auth');
Route::post('/planes/materias', [MateriaController::class, 'store'])->name('planes.materias.store')->middleware('auth');
Route::get('/planes/materias/{id}/edit', [MateriaController::class, 'edit'])->name('planes.materias.edit')->middleware('auth');
Route::put('/planes/materias/{id}', [MateriaController::class, 'update'])->name('planes.materias.update')->middleware('auth');
Route::delete('/planes/materias/{id}', [MateriaController::class, 'destroy'])->name('planes.materias.destroy')->middleware('auth');
//rutas para gestiones académicas
Route::get('/planes/gestiones', [GestionAcademicaController::class, 'index'])->name('admin.gestionacademica.index')->middleware('auth');
Route::get('/planes/gestiones/create', [GestionAcademicaController::class, 'create'])->name('admin.gestionacademica.create')->middleware('auth');
Route::post('/planes/gestiones', [GestionAcademicaController::class, 'store'])->name('admin.gestionacademica.store')->middleware('auth');
Route::get('/planes/gestiones/{id}/edit', [GestionAcademicaController::class, 'edit'])->name('admin.gestionacademica.edit')->middleware('auth');
Route::put('/planes/gestiones/{id}', [GestionAcademicaController::class, 'update'])->name('admin.gestionacademica.update')->middleware('auth');
Route::delete('/planes/gestiones/{id}', [GestionAcademicaController::class, 'destroy'])->name('admin.gestionacademica.destroy')->middleware('auth');
//rutas para calendario y actividades
Route::get('/planes/calendario', [ActividadController::class, 'index'])->name('admin.actividad.index')->middleware('auth');
Route::get('/planes/calendario/create', [ActividadController::class, 'create'])->name('admin.actividad.create')->middleware('auth');
Route::post('/planes/calendario', [ActividadController::class, 'store'])->name('admin.actividad.store')->middleware('auth');
Route::get('/planes/calendario/{id}/edit', [ActividadController::class, 'edit'])->name('admin.actividad.edit')->middleware('auth');
Route::put('/planes/calendario/{id}', [ActividadController::class, 'update'])->name('admin.actividad.update')->middleware('auth');
Route::delete('/planes/calendario/{id}', [ActividadController::class, 'destroy'])->name('admin.actividad.destroy')->middleware('auth');
//rutas para grupos
Route::get('/planes/grupos', [GrupoController::class, 'index'])->name('admin.grupos.index')->middleware('auth');
Route::get('/planes/grupos/programar', [GrupoController::class, 'programar'])->name('admin.grupos.programar')->middleware('auth');
Route::post('/planes/grupos', [GrupoController::class, 'store'])->name('admin.grupos.store')->middleware('auth');
Route::get('/planes/grupos/{id}/edit', [GrupoController::class, 'edit'])->name('admin.grupos.edit')->middleware('auth');
Route::put('/planes/grupos/{id}', [GrupoController::class, 'update'])->name('admin.grupos.update')->middleware('auth');
Route::delete('/planes/grupos/{id}', [GrupoController::class, 'destroy'])->name('admin.grupos.destroy')->middleware('auth');
//rutas para asignación docente (horarios)
Route::get('/planes/horarios', [AsignacionDocenteController::class, 'index'])->name('admin.asignacion-docente.index')->middleware('auth');
Route::get('/planes/horarios/create', [AsignacionDocenteController::class, 'create'])->name('admin.asignacion-docente.create')->middleware('auth');
Route::get('/planes/horarios/{id}/edit', [AsignacionDocenteController::class, 'edit'])->name('admin.asignacion-docente.edit')->middleware('auth');
Route::put('/planes/horarios/{id}', [AsignacionDocenteController::class, 'asignar'])->name('admin.asignacion-docente.asignar')->middleware('auth');