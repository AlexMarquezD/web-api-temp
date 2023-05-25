<?php

use App\Http\Controllers as Controller;
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

Route::post('login', [Controller\LoginController::class, 'login'])->name('login');
Route::post('register', [Controller\UserController::class, 'store'])->name('user.store');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [Controller\LogoutController::class, 'logout'])->name('logout');
    Route::get('user/{id}', [Controller\UserController::class, 'show'])->middleware('permission:user-show')->name('user.show');
    Route::get('user', [Controller\UserController::class, 'index'])->middleware('permission:user-index')->name('user.index');
    Route::put('user/{id}', [Controller\UserController::class, 'update'])->middleware('permission:user-update')->name('user.update');
    Route::delete('user/{id}', [Controller\UserController::class, 'destroy'])->middleware('permission:user-delete')->name('user.delete');
});
