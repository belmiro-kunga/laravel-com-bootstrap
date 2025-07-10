<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DenunciaController;

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

// Rotas públicas
Route::post('/auth/login', [AuthController::class, 'login']);

// Rotas protegidas
Route::middleware('auth:sanctum')->group(function () {
    // Autenticação
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::put('/auth/notification-preferences', [AuthController::class, 'updateNotificationPreferences']);
    Route::get('/auth/tokens', [AuthController::class, 'tokens']);
    Route::delete('/auth/tokens/{token}', [AuthController::class, 'revokeToken']);

    // Denúncias
    Route::apiResource('denuncias', DenunciaController::class);
    Route::post('/denuncias/{denuncia}/alterar-status', [DenunciaController::class, 'alterarStatus']);
    Route::get('/denuncias/metrics', [DenunciaController::class, 'metrics']);
    Route::get('/denuncias/filters', [DenunciaController::class, 'filters']);

    // Rota de teste
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    });
});

// Rota de health check
Route::get('/health', function () {
    return response()->json([
        'success' => true,
        'message' => 'API funcionando corretamente',
        'timestamp' => now()->toISOString(),
        'version' => '1.0.0'
    ]);
});
