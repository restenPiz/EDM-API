<?php

use App\Http\Controllers\occurrenceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//*Occurrence routes
Route::get('/occurrences', [occurrenceController::class, 'index']);
Route::post('/storeOccurrences', [occurrenceController::class, 'store']);
Route::post('/updateOccurrences/{id}', [occurrenceController::class, 'update']);
Route::post('/deleteOccurrences/{id}', [occurrenceController::class, 'delete']);