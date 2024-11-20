<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/peserta', [PesertaController::class, 'index']);
    Route::post('/peserta/create', [PesertaController::class, 'store']);
    Route::post('/peserta/update/{id}', [PesertaController::class, 'update']);
    Route::delete('/peserta/delete/{id}', [PesertaController::class, 'destroy']);

    Route::get('/event', [EventController::class, 'index']);
    Route::post('/event/create', [EventController::class, 'store']);
    Route::post('/event/update/{id}', [EventController::class, 'update']);
    Route::get('/event/search/{name_event}', [EventController::class, 'search']);
    Route::delete('/event/delete/{id}', [EventController::class, 'destroy']);

    Route::get('/', [UserController::class, 'index']);
    Route::post('/update/{id}', [UserController::class, 'update']);
    Route::delete('/delete/{id}', [UserController::class, 'destroy']);
    Route::post('/logout', [UserController::class, 'logout']);

    Route::get('/jadwal', [JadwalController::class,'index']);
    Route::post('/jadwal/create', [JadwalController::class,'store']);
    Route::post('/jadwal/update/{id}', [JadwalController::class,'update']);
    Route::delete('/jadwal/delete/{id}', [JadwalController::class,'destroy']);
    Route::get('/jadwal/search/{judul_sesi}', [JadwalController::class,'search']);
});
