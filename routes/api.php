<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\Api\OrdenServicioController;
use App\Http\Controllers\Api\HorarioController;


Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/clientes', [ClienteController::class, 'index']);
    Route::post('/clientes', [ClienteController::class, 'store']);
    Route::get('/clientes/{cedula}', [ClienteController::class, 'show']);
    Route::patch('/clientes/{cedula}', [ClienteController::class, 'update']);
    Route::delete('/clientes/{cedula}', [ClienteController::class, 'destroy']);

    Route::apiResource('ordenes-servicio', OrdenServicioController::class)
    ->parameters(['ordenes-servicio' => 'id']);

    Route::apiResource('horarios', HorarioController::class)
        ->parameters(['horarios' => 'id']);
});
