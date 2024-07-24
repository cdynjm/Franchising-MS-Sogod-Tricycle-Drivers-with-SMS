<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->group(function () {
    
    Route::group(['middleware' => 'admin'], function () {

        Route::group(['prefix' => 'create'], function () {
            Route::post('/category', [AdminController::class, 'createCategory']);
        }); 

        Route::group(['prefix' => 'update'], function () {
            Route::patch('/category', [AdminController::class, 'updateCategory']);
            Route::patch('/confirm-franchise-application', [AdminController::class, 'confirmFranchiseApplication']);
            Route::patch('/approve-franchise-application', [AdminController::class, 'approveFranchiseApplication']);
            Route::patch('/confirm-franchise-renewal', [AdminController::class, 'confirmFranchiseRenewal']);
            Route::patch('/approve-franchise-renewal', [AdminController::class, 'approveFranchiseRenewal']);
            Route::patch('/profile', [AdminController::class, 'updateProfile']);
            Route::patch('/sms-token', [AdminController::class, 'smsToken']);
            Route::patch('/signature', [AdminController::class, 'updateSignature']);

        });
        
        Route::group(['prefix' => 'delete'], function () {
            Route::delete('/category', [AdminController::class, 'deleteCategory']);
            Route::delete('/reject-franchise-application', [AdminController::class, 'rejectFranchiseApplication']);
            Route::delete('/reject-franchise-renewal', [AdminController::class, 'rejectFranchiseRenewal']);
        });

    });

    Route::group(['middleware' => 'user'], function () {

        Route::group(['prefix' => 'update'], function () {
            Route::patch('/submit-renewal', [UserController::class, 'submitRenewal']);
            Route::patch('/user-profile', [UserController::class, 'updateProfile']);
        });

    });

});
