<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifyEmailController;
use App\Http\Controllers\ProductController;

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
Route::post('/forgetPassword', [UserController::class, 'forgetPassword'])->name('forgetPassword');
Route::post('resetPassword', [UserController::class, 'reset']);
Route::get('/verify', [VerifyEmailController::class, 'VerifyEmail'])->name('verify');
Route::post('/resend', [VerifyEmailController::class, 'resendMail'])->name('resend');
Route::post('register',[userController::class,'register']);
Route::post('login',[UserController::class,'login']);
Route::post('logout',[UserController::class,'logout'])->middleware('auth:sanctum');


Route::get('/bestWoman', [ProductController::class, 'bestWoman']);
Route::post('/uploadsImage', [ProductController::class, 'uploadsImage']);
Route::post('/createProduct', [ProductController::class, 'createProduct']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
