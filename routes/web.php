<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForgotPasswordController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/storage', function () {
    Artisan::call('storage:link');
});

//guest user
Route::group(['middleware' => 'guest'], function () {
	Route::get('/', [LoginController::class, 'login'])->name('login');
	Route::get('/login', [LoginController::class, 'login'])->name('login');
	Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');

	Route::get('/forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('forgot-password');
	Route::get('/confirm-OTP/{id}/{resetID}', [ForgotPasswordController::class, 'confirmOTP'])->name('confirm-OTP');
	Route::get('/reset-password/{id}/{resetID}', [ForgotPasswordController::class, 'resetPassword'])->name('reset-password');

    Route::get('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/submit-application', [RegisterController::class, 'submitApplication'])->name('register.authenticate');
});

//auth user
Route::group(['middleware' => 'auth'], function () {

	//this is the middleware for admin. only admin can access these routes listed here
	Route::group(['middleware' => 'admin'], function () {
		//prefix admin. refer to the url path of the browser. it will identify whether the logged user is admin or not
		// sample. localhost/admin/dashboard
		Route::group(['prefix' => 'admin'], function () {
			Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
			Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
			Route::get('/renewal', [AdminController::class, 'renewal'])->name('admin.renewal');
			Route::get('/new-application', [AdminController::class, 'newApplication'])->name('admin.new-application');
			Route::get('/view-application/{id}', [AdminController::class, 'viewApplication'])->name('view-application');
			Route::get('/view-category/{id}', [AdminController::class, 'viewCategory'])->name('admin.view-category');
			Route::get('/view-franchise-history/{id}', [AdminController::class, 'viewFranchiseHistory'])->name('view-franchise-history');

			Route::post('/application-form', [AdminController::class, 'applicationForm'])->name('application-form');
			Route::post('/permit-form', [AdminController::class, 'permitForm'])->name('permit-form');
			Route::post('/confirmation-form', [AdminController::class, 'confirmationForm'])->name('confirmation-form');
			Route::post('/provisional-form', [AdminController::class, 'provisionalForm'])->name('provisional-form');

			Route::get('/reports', [AdminController::class, 'reports']);
			Route::post('/generate-report', [AdminController::class, 'reports']);

			Route::get('/walk-in-renew-franchise/{unit}/{id}', [AdminController::class, 'renewFranchise'])->name('admin.renew-franchise');
			Route::get('/change-owner-motor/{unit}/{id}', [AdminController::class, 'changeOwnerMotor'])->name('admin.change-owner-motor');
			Route::get('/add-previous-data', [AdminController::class, 'addPreviousData'])->name('admin.previous-data');
		});
	});

	//this is the middleware for user. only user can access these routes listed here
	Route::group(['middleware' => 'user'], function () {
		//prefix user. refer to the url path of the browser. it will identify whether the logged user is user or not
		// sample. localhost/user/dashboard
		Route::group(['prefix' => 'user'], function () {
			Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
			Route::get('/renew-franchise/{unit}', [UserController::class, 'renewFranchise'])->name('user.renew-franchise');
			Route::get('/renewal-history', [UserController::class, 'renewalHistory'])->name('user.renewal-history');
			Route::get('/view-application/{id}', [UserController::class, 'viewApplication'])->name('user.view-application');
			Route::get('/edit-application/{id}', [UserController::class, 'editApplication'])->name('user.edit-application');
			Route::get('/upload-forms/{id}', [UserController::class, 'uploadForms'])->name('user.upload-forms');

			Route::post('/application-form', [UserController::class, 'applicationForm'])->name('user.application-form');
			Route::post('/permit-form', [UserController::class, 'permitForm'])->name('user.permit-form');
			Route::post('/confirmation-form', [UserController::class, 'confirmationForm'])->name('user.confirmation-form');
			Route::post('/provisional-form', [UserController::class, 'provisionalForm'])->name('user.provisional-form');

			Route::post('/download-QRCode', [UserController::class, 'downloadQRCode'])->name('user.download-qrcode');

		});
	});

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});