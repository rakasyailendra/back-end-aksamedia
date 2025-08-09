<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DivisionController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\AuthController; // <-- Tambahkan ini

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route untuk Logout
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']); // <-- Tambahkan route ini

Route::apiResource('/divisions', DivisionController::class)->middleware('auth:sanctum');
Route::apiResource('/employees', EmployeeController::class)->middleware('auth:sanctum');
