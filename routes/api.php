<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampaignsController;
use App\Http\Controllers\FederalDistrictController;
use App\Http\Controllers\LocalDistrictController;
use App\Http\Controllers\MunicipalityController;
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

//campaign
Route::middleware('jwt')->prefix('campaigns')->group(function() {
    Route::get('/', [CampaignsController::class, 'getCurrentCampaign'])->name('api.campaigns.getCampaign');
});
//Voluntarios

Route::middleware('jwt')->prefix('states')->group(function() {
    Route::get('/', [StateController::class, 'getAllStates'])->name('api.states.getAll');
    Route::get('/{id}', [StateController::class, 'getById'])->name('api.states.getById');
});

Route::middleware('jwt')->prefix('sections')->group(function() {
    Route::get('/', [SectionsController::class, 'getAllSections'])->name('api.sections.getAll');
    Route::get('/{id}', [SectionsController::class, 'getById'])->name('api.sections.getById');
});

Route::middleware('jwt')->prefix('municipalities')->group(function() {
    Route::get('/', [MunicipalityController::class, 'getMunicipalitiesByState'])->name('api.municipalities.getAll');
    Route::get('/{id}', [MunicipalityController::class, 'getById'])->name('api.municipalities.getById');
});

Route::middleware('jwt')->prefix('federal-districts')->group(function() {
    Route::get('/', [FederalDistrictController::class, 'getFederalDistrictsByState'])->name('api.federal-districts.getAll');
    Route::get('/{id}', [FederalDistrictController::class, 'getById'])->name('api.federal-districts.getById');
});

Route::middleware('jwt')->prefix('local-districts')->group(function() {
    Route::get('/', [LocalDistrictController::class, 'getLocalDistrictsByState'])->name('api.local-districts.getAll');
    Route::get('/{id}', [LocalDistrictController::class, 'getById'])->name('api.local-districts.getById');
});
