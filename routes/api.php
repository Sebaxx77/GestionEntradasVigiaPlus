<?php

use App\Http\Controllers\AgendamientoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('api')->group(function () {
    // Crear un agendamiento (POST)
    Route::post('/agendamientos', [AgendamientoController::class, 'store']);
    
    // Actualizar un agendamiento (PUT/PATCH)
    Route::put('/agendamientos/{id}', [AgendamientoController::class, 'update']);
    
    // Consultar/agregar listado de agendamientos (GET)
    Route::get('/agendamientos', [AgendamientoController::class, 'index']);
});
