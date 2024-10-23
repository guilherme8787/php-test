<?php

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

Route::middleware(['auth:sanctum', 'cheetos'])->group(function () {
    Route::get('/healthcheck', function (Request $request) {
        return true;
    });

    Route::group(['prefix' => 'players'], function () {
        Route::get('/', App\Http\Controllers\Players\GetAllPlayerController::class)
            ->name('players.all');

        Route::get('/{id}', App\Http\Controllers\Players\GetPlayerController::class)
            ->name('players.show');

        Route::post('/', App\Http\Controllers\Players\StorePlayerController::class)
            ->name('players.store');

        Route::put('/{id}', App\Http\Controllers\Players\UpdatePlayerController::class)
            ->name('players.update');

        Route::delete('/{id}', App\Http\Controllers\Players\DeletePlayerController::class)
            ->name('players.delete');
    });
});

Route::post('/login', App\Http\Controllers\AuthController::class)
    ->name('login');
