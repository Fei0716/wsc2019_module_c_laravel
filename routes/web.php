<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes--------------------------------------------------------------------
|
|------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('', [AuthController::class, 'login'])->name('loginPage');
Route::post('login', [AuthController::class, 'loginOrganizer'])->name('login');

Route::middleware('auth', 'preventReturnAfterLogout')->group(function () {
    Route::resource('event', EventController::class)->only('index', 'create', 'store');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::middleware('checkOrganizer')->group(function () {
        Route::resource('event', EventController::class)->except('index', 'create', 'store');
        Route::resource('event/{event}/ticket', TicketController::class);
        Route::resource('event/{event}/session', SessionController::class);
        Route::resource('event/{event}/channel', ChannelController::class);
        Route::resource('event/{event}/room', RoomController::class);
        Route::resource('event/{event}/capacity', ReportController::class);
    });


});

