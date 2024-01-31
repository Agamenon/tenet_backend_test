<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
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

Route::group(['prefix' => 'v1'], function () use ($router) {
    /** @var Route $router */
    $router->post('/auth/sign_in', [LoginController::class, 'login'])->name('user.login');

    $router->group(['middleware' => ['auth:sanctum', 'throttle:api']], function () use ($router) {
        $router->apiResource('customer',CustomerController::class);
    });
});
