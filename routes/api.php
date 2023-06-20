<?php

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

// Authenticated only API
// We use auth api here as a middleware so only authenticated user who can access the endpoint
// We use group so we can apply middleware auth api to all the routes within the group

Route::prefix('v1')
    ->as('v1.')
    ->group(function () {
        /**
         * Authorized routes
         */
        Route::middleware('auth:api')->group(function () {
            Route::prefix('auth')->group(function () {
                Route::post('/logout', 'AuthController@logout');
                Route::post('/register', 'AuthController@register');
                Route::get('/me', 'AuthController@me');
                Route::post('/login', 'AuthController@login')->withoutMiddleware(['auth:api']);
            });

            Route::middleware('checkUserRole')->group(function () {
                Route::apiResource('users', 'UserController')->except(['show']);
            });

            Route::apiResource('orders', 'OrderController')->except(['show']);
        });
    });
