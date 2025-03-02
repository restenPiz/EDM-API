<?php

use App\Http\Controllers\occurrenceController;
use App\Http\Controllers\ptController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;

//*Occurrence routes
Route::get('/occurrences', [occurrenceController::class, 'index']);
Route::post('/storeOccurrences', [occurrenceController::class, 'store']);
Route::post('/updateOccurrences/{id}', [occurrenceController::class, 'update']);
Route::post('/deleteOccurrences/{id}', [occurrenceController::class, 'delete']);

//*Board routes
Route::get('/boards', [occurrenceController::class, 'boards']);
Route::post('/storeBoards', [occurrenceController::class, 'storeBoards']);
Route::post('/updateBoards/{id}', [occurrenceController::class, 'updateBoards']);
Route::post('/deleteBoards/{id}', [occurrenceController::class, 'deleteBoards']);

//*Pt routes
Route::get('/pts', [ptController::class, 'index']);
Route::post('/storePts', [ptController::class, 'store']);
Route::post('/updatePts/{id}', [ptController::class, 'update']);
Route::post('/deletePts/{id}', [ptController::class, 'delete']);
Route::get('/showPts/{id}', [ptController::class, 'show']);

//*Users routes
Route::get('/users', [userController::class, 'index']);
Route::post('/storeUsers', [userController::class, 'store']);
Route::post('/updateUsers/{id}', [userController::class, 'update']);
Route::post('/deleteUsers/{id}', [userController::class, 'delete']);