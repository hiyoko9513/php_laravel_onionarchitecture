<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthorisationController;
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
// Route::post('/password/forgot',[AuthController::class,'passwordForgot'])->name('password.forgot'); // todo tokenをメールに付属する
// Route::post('/password/reset', [AuthController::class, 'passwordReset'])->name('password.reset'); // todo tokenを受け取る
//
Route::group(['middleware' => ['jwt.auth']], static function () {
    Route::post('/logout', [AuthorisationController::class, 'logout'])->name('logout');
    Route::post('/refresh', [AuthorisationController::class, 'refresh'])->name('refresh');
});
