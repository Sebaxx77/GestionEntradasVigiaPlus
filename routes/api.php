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

// Modificación prefijo 
Route::prefix('agendamientos/formato-descarga')->group(function () {
    // Ruta para crear un formato descarga (POST)
    Route::post('/', [AgendamientoFormatoDescargaController::class, 'store'])->middleware('throttle:3,10')->name('agendamiento.formato-descarga.store');

    // Ruta para actualizar (por ejemplo, aprobación/rechazo) de un formato descarga (PUT)
    Route::put('/{id}', [AgendamientoFormatoDescargaController::class, 'update'])->name('agendamiento.formato-descarga.update');

    // Ruta para obtener los formatos descarga en estado aprobado/rechazado (GET)
    Route::get('/otros', [AgendamientoFormatoDescargaController::class, 'otros'])->name('agendamiento.formato-descarga.otros');

    // Ruta para obtener los formatos descarga en estado pendiente (GET)
    Route::get('/pendientes', [AgendamientoFormatoDescargaController::class, 'pendientes'])->name('agendamiento.formato-descarga.pendientes');

    // Ruta para obtener todas las solicitudes sin importar el estado (GET)
    Route::get('/todas', [AgendamientoFormatoDescargaController::class, 'todas'])->name('agendamiento.formato-descarga.todas');
});
