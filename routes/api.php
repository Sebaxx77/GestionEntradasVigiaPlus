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

Route::prefix('agendamientos/formato-descarga')->group(function () {
    // Ruta para crear un formato descarga (POST)
    Route::post('/', [AgendamientoFormatoDescargaController::class, 'store'])
        ->name('agendamiento.formato-descarga.store');

    // Rutas sin middleware de validación de token
    Route::put('/{id}', [AgendamientoFormatoDescargaController::class, 'update'])
        ->name('agendamiento.formato-descarga.update');

    Route::get('/otros', [AgendamientoFormatoDescargaController::class, 'otros'])
        ->name('agendamiento.formato-descarga.otros');

    Route::get('/pendientes', [AgendamientoFormatoDescargaController::class, 'pendientes'])
        ->name('agendamiento.formato-descarga.pendientes');

    Route::get('/todas', [AgendamientoFormatoDescargaController::class, 'todas'])
        ->name('agendamiento.formato-descarga.todas');
});
