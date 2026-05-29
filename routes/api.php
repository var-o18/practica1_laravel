<?php

use App\Http\Controllers\AlumnoController;
use Illuminate\Support\Facades\Route;

Route::get('alumnos', [AlumnoController::class, 'obtenerTodos']);
Route::post('alumnos', [AlumnoController::class, 'crear']);

Route::middleware('positive.integer.id')->group(function () {
    Route::get('alumnos/{id}', [AlumnoController::class, 'obtenerPorId']);
    Route::put('alumnos/{id}', [AlumnoController::class, 'modificar']);
    Route::patch('alumnos/{id}', [AlumnoController::class, 'modificar']);
    Route::delete('alumnos/{id}', [AlumnoController::class, 'borrar']);
});
