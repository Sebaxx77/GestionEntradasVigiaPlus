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
    // Ruta para recibir los datos del formulario (POST)
    Route::post('/', [AgendamientoFormatoDescargaController::class, 'storeFormatoDescarga'])->name('api.agendamiento.formato-descarga.store');

    // Ruta para obtener solicitudes de formato-descarga y enviarlas a la UI
    Route::get('/', [AgendamientoFormatoDescargaController::class, 'indexFormatoDescarga'])->name('api.agendamiento.formato-descarga.index');
});

