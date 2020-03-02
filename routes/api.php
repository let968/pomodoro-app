<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskListController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'auth:api'
], function () {
    Route::group(['prefix' => 'user'], function () {
    });
    
    Route::group(['prefix' => 'lists'], function () {
        Route::get('/', '\\' . TaskListController::class . '@index');
        Route::post('/', '\\' . TaskListController::class . '@create');

        Route::get('/{id}', '\\' . TaskListController::class . '@view');
        Route::put('/{id}', '\\' . TaskListController::class . '@update');

        Route::group(['prefix' => '/{listId}/tasks'], function () {
            Route::get('/', '\\' . TaskController::class . '@index');
            Route::post('/', '\\' . TaskController::class . '@create');
            
            Route::get('/{id}', '\\' . TaskController::class . '@view');
            Route::put('/{id}', '\\' . TaskController::class . '@update');
        });
    });
});
