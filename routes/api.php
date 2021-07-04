<?php

use App\Http\Controllers\Api\adminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\documentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login', [AuthController::class, 'login'])->name('login');


Route::prefix('admin')->middleware('auth:api')->group(function(){
    Route::apiResources([
        'documents' => documentController::class,
        'users' => adminController::class,
    ]);
    Route::post('upload/file/{id}', [documentController::class, 'uploadFile']);

    Route::get('documents/search/{keyword}', [documentController::class, 'search']);


});

