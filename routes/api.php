<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForgotPasswordController;
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

//these are API routes. it is used by the javascript request through axios to send request to the server 

Route::post('/get-province', [RegisterController::class, 'Province']);
Route::post('/get-municipal', [RegisterController::class, 'Municipal']);
Route::post('/get-barangay', [RegisterController::class, 'Barangay']);

Route::post('/send-otp', [ForgotPasswordController::class, 'sendOTP']);
Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOTP']);
Route::post('/reset-password', [ForgotPasswordController::class, 'newPassword']);

//sanctum serve as the security for the api endpoints. every request needs to have access token/authorization bearer before they can access the API
Route::middleware('auth:sanctum')->group(function () {
    
    //this is the middleware for admin. only admin can access these API routes listed here
    Route::group(['middleware' => 'admin'], function () {

        Route::group(['prefix' => 'get'], function () {
            Route::post('/users', [AdminController::class, 'getUsersByCategory']);
            Route::post('/data-analytics-users', [AdminController::class, 'getDataAnalyticsUsers']);
        }); 

        Route::group(['prefix' => 'create'], function () {
            Route::post('/category', [AdminController::class, 'createCategory']);
            Route::post('/previous-records', [AdminController::class, 'createPreviousRecords']);
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
            Route::patch('/walk-in-submit-renewal', [AdminController::class, 'submitRenewal']);

        });
        
        Route::group(['prefix' => 'delete'], function () {
            Route::delete('/category', [AdminController::class, 'deleteCategory']);
            Route::delete('/reject-franchise-application', [AdminController::class, 'rejectFranchiseApplication']);
            Route::delete('/reject-franchise-renewal', [AdminController::class, 'rejectFranchiseRenewal']);
        });

    });

    //this is the middleware for user. only user can access these API routes listed here
    Route::group(['middleware' => 'user'], function () {

        Route::group(['prefix' => 'create'], function () {
            Route::post('/upload-form-with-signature', [UserController::class, 'uploadFormSignature']);
        });

        Route::group(['prefix' => 'update'], function () {
            Route::patch('/resubmit-application', [UserController::class, 'resubmitApplication']);
            Route::patch('/submit-renewal', [UserController::class, 'submitRenewal']);
            Route::patch('/user-profile', [UserController::class, 'updateProfile']);

        });

    });

});
