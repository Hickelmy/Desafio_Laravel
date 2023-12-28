<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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


Route::post("/auth/register",[UserController::class , 'createUser']);
Route::post("/auth/login",[UserController::class , 'loginUser']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('produtos')->group(function () {
    Route::post("add",[ProductController::class , 'create']);
    Route::put("update",[ProductController::class , 'update']);
    Route::delete("delete",[ProductController::class , 'delete']);
    Route::get("get",[ProductController::class , 'getData']);
    Route::get("getbyid",[ProductController::class , 'getById']);
});

Route::prefix('categories')->group(function () {
    Route::post("add",[CategoryController::class , 'create']);
    Route::put("update",[CategoryController::class , 'update']);
    Route::delete("delete",[CategoryController::class , 'delete']);
    Route::get("get",[CategoryController::class , 'getData']);
    Route::get("getbyid",[CategoryController::class , 'getById']);
});




// Route::prefix('categories')->group(function () {
//     Route::get('/', [CategoryController::class, 'index']);
//     Route::get('/{id}', [CategoryController::class, 'show']);
//     Route::post('/', [CategoryController::class, 'store']);
//     Route::put('/{id}', [CategoryController::class, 'update']);
//     Route::delete('/{id}', [CategoryController::class, 'destroy']);
// });

// Route::prefix('categories')->group(function () {
//     Route::get('/', [CategoryController::class, 'index']);
//     Route::get('/{id}', [CategoryController::class, 'show']);
//     Route::post('/', [CategoryController::class, 'store']);
//     Route::put('/{id}', [CategoryController::class, 'update']);
//     Route::delete('/{id}', [CategoryController::class, 'destroy']);
// });