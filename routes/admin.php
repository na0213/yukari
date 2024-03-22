<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Admin\AuthenticatedSessionController;
use App\Http\Controllers\Auth\Admin\ConfirmablePasswordController;
use App\Http\Controllers\Auth\Admin\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\Admin\EmailVerificationPromptController;
use App\Http\Controllers\Auth\Admin\NewPasswordController;
use App\Http\Controllers\Auth\Admin\PasswordController;
use App\Http\Controllers\Auth\Admin\PasswordResetLinkController;
use App\Http\Controllers\Auth\Admin\RegisteredUserController;
use App\Http\Controllers\Auth\Admin\VerifyEmailController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\RegionController;
use App\Http\Controllers\Backend\TitleController;

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

Route::get('/', function () {
    return view('backend.welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth:admins')->group(function () {
   Route::get('/dashboard', function(){
	   return view('admin.dashboard');
   })->middleware('verified')->name('dashboard');

    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::controller(AdminController::class)->group(function () {
        Route::get('/dashboard', 'index')->middleware('verified')->name('dashboard');
        });

    Route::controller(RegionController::class)->group(function () {
        Route::get('/regions', 'index')->name('backend.regions.index');
        Route::get('/regions/create', 'create')->name('backend.regions.create');
        Route::post('/regions', 'store')->name('backend.regions.store');
        Route::get('/regions/{id}/edit', 'edit')->name('backend.regions.edit');
        Route::put('/regions/{id}', 'update')->name('backend.regions.update');
        Route::delete('/regions/{id}', 'destroy')->name('backend.regions.destroy');
        });

    Route::controller(TitleController::class)->group(function () {
        Route::get('/titles', 'index')->name('backend.titles.index');
        Route::get('/titles/create/{region}', 'create')->name('backend.titles.create');
        Route::post('/titles/{region}', 'store')->name('backend.titles.store');
        Route::get('/titles/{id}/edit', 'edit')->name('backend.titles.edit');
        Route::put('/titles/{id}', 'update')->name('backend.titles.update');
        Route::delete('/titles/{id}', 'destroy')->name('backend.titles.destroy');
        });
});
