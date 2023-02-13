<?php

use App\Http\Controllers\CampaignsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UnAuthorizedController;
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

Route::get('/', [UnAuthorizedController::class, 'index'])->name('root');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::prefix('campaig')->group(function() {
    Route::get('/', [CampaignsController::class, 'index'])->name('campaign.index');
    Route::get('/create', [CampaignsController::class, 'create'])->name('campaign.create');
});

Route::prefix('profile')->group(function() {
    Route::get('/', [ProfileController::class, 'index'])->name('profile.show');
});

