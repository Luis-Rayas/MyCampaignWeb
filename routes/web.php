<?php

use App\Http\Controllers\AdministratorsController;
use App\Http\Controllers\CampaignsController;
use App\Http\Controllers\FederalDistrictController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocalDistrictController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\SympathizersController;
use App\Http\Controllers\UnAuthorizedController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->get('/', [UnAuthorizedController::class, 'index'])->name('root');
Route::middleware('guest')->get('/no-autorized', [UnAuthorizedController::class, 'noAccessSympathizer'])->name('no-access-sympathizer');

Route::middleware('auth')->get('/dashboard', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::middleware('auth')->prefix('campaig')->group(function() {
    Route::get('/', [CampaignsController::class, 'index'])->name('campaign.index');

    Route::get('/create', [CampaignsController::class, 'create'])->name('campaign.create');
    Route::post('/store', [CampaignsController::class, 'store'])->name('campaign.store');

    Route::get('/edit/{id}', [CampaignsController::class, 'edit'])->name('campaign.edit');
    Route::put('/update}', [CampaignsController::class, 'update'])->name('campaign.update');

    Route::get('/{id}', [CampaignsController::class, 'show'])->name('campaign.show');

    Route::delete('/delete/{id}', [CampaignsController::class, 'delete'])->name('campaign.delete');
});

Route::middleware('auth')->prefix('users')->group(function() {
    Route::prefix('admin')->group(function() {
        Route::get('/', [AdministratorsController::class, 'index'])->name('admin.index');

        Route::delete('/delete/{id}', [AdministratorsController::class, 'delete'])->name('admin.delete');
    });

    Route::prefix('sympathizer')->group(function() {
        Route::get('/', [SympathizersController::class, 'index'])->name('sympathizer.index');

        Route::delete('/delete/{id}', [SympathizersController::class, 'delete'])->name('sympathizer.delete');
    });

    Route::get('/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/store', [UserController::class, 'store'])->name('user.store');

});

Route::middleware('auth')->prefix('districts')->group(function() {
    Route::prefix('federal')->group(function() {
        Route::get('/', [FederalDistrictController::class, 'index'])->name('federal.index');
    });

    Route::prefix('local')->group(function() {
        Route::get('/', [LocalDistrictController::class, 'index'])->name('local.index');
    });
});

Route::middleware('auth')->prefix('states')->group(function() {
    Route::get('/', [StateController::class, 'index'])->name('state.index');
});

Route::middleware('auth')->prefix('municipalities')->group(function() {
    Route::get('/', [MunicipalityController::class, 'index'])->name('municipality.index');
});

Route::middleware('auth')->prefix('sections')->group(function() {
    Route::get('/', [SectionsController::class, 'index'])->name('sections.index');
});

Route::middleware('auth')->prefix('profile')->group(function() {
    Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
});

