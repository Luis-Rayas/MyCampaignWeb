<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\StateController;
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

// Route::post('auth/login', [AuthController::class, 'login']);
// Route::post('auth/logout', [AuthController::class, 'logout']);
// Route::post('auth/me', [AuthController::class, 'me'])->middleware('jwt');



Route::prefix('auth')->group(function() {
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('jwt')->group(function() {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class,'me']);
    });
});

Route::middleware('jwt')->prefix('states')->group(function() {
    Route::get('/', [StateController::class, 'getAllStates'])->name('api.states.getAll');
});

Route::middleware('jwt')->prefix('sections')->group(function() {
    Route::get('/', [SectionsController::class, 'getAllSections'])->name('api.sections.getAll');
});
/*
Route::middleware('jwt')->prefix('municipalities')->group(function() {
    Route::get('/', [StateController::class, 'getAllStates'])->name('api.municipalities.getAll');
});

Route::middleware('jwt')->prefix('federal-districts')->group(function() {
    Route::get('/', [StateController::class, 'getAllStates'])->name('api.federal-districts.getAll');
});

Route::middleware('jwt')->prefix('local-districts')->group(function() {
    Route::get('/', [StateController::class, 'getAllStates'])->name('api.local-districts.getAll');
});*/
