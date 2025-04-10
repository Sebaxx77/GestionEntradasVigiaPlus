<?php

use App\Http\Controllers\AgendamientoController;
use App\Http\Controllers\Agendamientos\AgendamientoFormatoDescargaController;
use App\Http\Controllers\API\AuthController; // Asegúrate de que este namespace sea correcto
use App\Http\Controllers\CorreosNotificables\CorreoNotificableController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Operaciones\OperacionController;
use App\Http\Controllers\ParquesIndustriales\ParqueController;
use App\Http\Controllers\Seguridad\PermissionController;
use App\Http\Controllers\Seguridad\RoleController;
use App\Http\Controllers\Usuarios\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aquí se definen todas las rutas de la API para tu aplicación.
|
*/

// Rutas públicas o sin middleware de validación de token

// Rutas de Autenticación
Route::post('auth/login', [AuthController::class, 'login'])->name('api.auth.login');
Route::post('auth/forgot-password', [AuthController::class, 'forgotPassword'])->name('api.auth.forgot-password');
Route::post('auth/reset-password', [AuthController::class, 'resetPassword'])->name('api.auth.reset-password');

// POST para crear un formato de descarga (limitado por throttle)
Route::post('agendamientos/formato-descarga', [AgendamientoFormatoDescargaController::class, 'store'])->middleware('throttle:5,1') // 5 peticiones por minuto
->name('agendamiento.formato-descarga.store');

// Rutas protegidas por middleware, auth:sanctum
Route::middleware('auth:sanctum')->group(function () {
    
    // Rutas de Autenticación
    Route::get('auth/me', [AuthController::class, 'me'])->name('api.auth.me');
    Route::post('auth/logout', [AuthController::class, 'logout'])->name('api.auth.logout');

    // Dashboard (acceso según rol)
    Route::get('dashboard', [DashboardController::class, 'index']);

    // Roles
    Route::apiResource('roles', RoleController::class);

    // Permisos
    Route::apiResource('permisos', PermissionController::class);

    // Operaciones
    Route::apiResource('operaciones', OperacionController::class);

    // Parques Industriales
    Route::apiResource('parques-industriales', ParqueController::class);

    // Correos Notificables
    Route::apiResource('correos-notificables', CorreoNotificableController::class);

    // Usuarios
    Route::apiResource('usuarios', UsuarioController::class);

    // Rutas del Formato de Descarga (excluyendo el POST ya declarado)
    Route::prefix('agendamientos/formato-descarga')->group(function () {
        Route::put('/{id}', [AgendamientoFormatoDescargaController::class, 'update'])
            ->name('agendamiento.formato-descarga.update');

        Route::get('/otros', [AgendamientoFormatoDescargaController::class, 'otros'])
            ->name('agendamiento.formato-descarga.otros');

        Route::get('/pendientes', [AgendamientoFormatoDescargaController::class, 'pendientes'])
            ->name('agendamiento.formato-descarga.pendientes');

        Route::get('/todas', [AgendamientoFormatoDescargaController::class, 'todas'])
            ->name('agendamiento.formato-descarga.todas');
    });
});