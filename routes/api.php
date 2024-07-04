<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;

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

Route::middleware('auth:api')->group(function () {
    Route::get('pro', function (Request $request) {
        return 'hey Product';
    });
    Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::apiResource('tasks', TaskController::class);
});

Route::post('register', [RegisterController::class, 'register'])->name('register');
Route::post('login', [LoginController::class, 'login'])->name('login');


// Route::get('tasks',[TaskController::class, 'index'])->name('index');
// Route::get('tasks/s',[TaskController::class, 'store'])->name('store');



