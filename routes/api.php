<?php

use App\Http\Controllers\API\v1\AuthController;
use App\Http\Controllers\API\v1\EventController;
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

Route::prefix('v1')->group(function () {
    Route::get('events', [EventController::class, 'index']);
    Route::get('organizers/{organizer}/events/{event}', [EventController::class, 'show']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('organizers/{organizer}/events/{event}/registration', [EventController::class, 'register']);
    Route::get('registrations', [EventController::class, 'getRegistrations']);
});
