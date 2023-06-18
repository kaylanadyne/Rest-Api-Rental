<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RentalController;

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


Route::prefix('/rental')->group(function(){
    Route::get('/',[RentalController::class,'index']);
    Route::post('/create',[RentalController::class,'store']);
    Route::get('/{id}',[RentalController::class,'show']);
    Route::post('/update/{id}',[RentalController::class,'update']);
    Route::post('/delete/{id}',[RentalController::class,'destroy']);  

    Route::prefix('/trash')->group(function(){
        Route::get('/all', [RentalController::class, 'getTrash']);
        Route::get('/restore/{id}', [RentalController::class, 'restore']);
        Route::post('/permanent/{id}', [RentalController::class, 'deleteTrash']);
    });

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});