<?php

use App\Http\Controllers\AgendamientoController;
use App\Http\Controllers\Agendamientos\AgendamientoFormatoDescargaController;
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

Route::prefix('agendamiento/formato-descarga')->group(function () {
    // Ruta para crear un formato descarga (POST)
    Route::post('/', [AgendamientoFormatoDescargaController::class, 'store'])->name('api.agendamiento.formato-descarga.store');

    // Ruta para actualizar (por ejemplo, aprobación/rechazo) de un formato descarga (PUT)
    Route::put('/{id}', [AgendamientoFormatoDescargaController::class, 'update'])->name('api.agendamiento.formato-descarga.update');

    // Ruta para obtener los formatos descarga filtrados por estado (GET)
    Route::get('/', [AgendamientoFormatoDescargaController::class, 'index'])->name('api.agendamiento.formato-descarga.index');
});

