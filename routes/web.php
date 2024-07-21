<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

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

Route::group(['middleware' => 'guest'], function () {
	Route::get('/', [LoginController::class, 'login'])->name('login');
	Route::get('/login', [LoginController::class, 'login'])->name('login');
	Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');

    Route::get('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/submit-application', [RegisterController::class, 'submitApplication'])->name('register.authenticate');
});

Route::group(['middleware' => 'auth'], function () {

	Route::group(['middleware' => 'admin'], function () {
		Route::group(['prefix' => 'admin'], function () {
			Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
			Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
			Route::get('/renewal', [AdminController::class, 'renewal'])->name('admin.renewal');
			Route::get('/new-application', [AdminController::class, 'newApplication'])->name('admin.new-application');
			Route::get('/view-application/{id}', [AdminController::class, 'viewApplication'])->name('view-application');
			Route::post('/application-form', [AdminController::class, 'applicationForm'])->name('application-form');
			Route::get('/view-category/{id}', [AdminController::class, 'viewCategory'])->name('admin.view-category');
			Route::get('/view-franchise-history/{id}', [AdminController::class, 'viewFranchiseHistory'])->name('view-franchise-history');

		});
	});

	Route::group(['middleware' => 'user'], function () {
		Route::group(['prefix' => 'user'], function () {
			Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
			Route::get('/renew-franchise/{unit}', [UserController::class, 'renewFranchise'])->name('user.renew-franchise');
			Route::get('/renewal-history', [UserController::class, 'renewalHistory'])->name('user.renewal-history');
			Route::get('/view-application/{id}', [UserController::class, 'viewApplication'])->name('user.view-application');
		});
	});

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});