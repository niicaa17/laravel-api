<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\TransaksiController;
use App\Http\Controllers\Api\IklanController;
use App\Http\Controllers\Api\PromoController;
use App\Http\Controllers\Api\ArtikelController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/infouser', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/user', UserController::class);
    Route::get('/home', [HomeController::class, 'index']);
    Route::apiResource('iklan', IklanController::class);
    Route::apiResource('promo', PromoController::class);
    Route::apiResource('artikel', ArtikelController::class);
    Route::apiResource('transaksi', TransaksiController::class);
    Route::get('/transaksi', [TransaksiController::class, 'index']);
    Route::post('/transaksi', [TransaksiController::class, 'store']);
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show']);
    Route::put('/transaksi/{id}', [TransaksiController::class, 'update']);
    Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy']);
    Route::get('user/detail', [UserController::class, 'detail']);
    Route::post('user/upload-foto', [UserController::class, 'uploadFoto']);
    Route::post('user/update-password', [UserController::class, 'updatePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
});