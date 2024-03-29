<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthorisationController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\User\UserController;
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

Route::post('/register', [AuthorisationController::class, 'register'])->name('register');
Route::post('/login', [AuthorisationController::class, 'login'])->name('login');
Route::post('/password/forgot', [PasswordController::class, 'forgot'])->name('password.forgot');
Route::post('/password/reset', [PasswordController::class, 'reset'])->name('password.reset');
Route::get('/users/{originalId}/unregistered', [UserController::class, 'unregistered'])->name('user.valid');

Route::group(['middleware' => ['jwt.auth']], static function () {
    Route::post('/logout', [AuthorisationController::class, 'logout'])->name('logout');
    Route::post('/refresh', [AuthorisationController::class, 'refresh'])->name('refresh');
});
