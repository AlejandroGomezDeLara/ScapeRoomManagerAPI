<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GameCategoryController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameReviewController;
use App\Http\Controllers\GameReviewSummaryController;
use App\Http\Controllers\GameSubcategoryController;
use App\Http\Controllers\OpenReservationController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SupportTicketController;

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

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class,'login']);
    Route::post('signup', [AuthController::class,'signup']);

    Route::resources([
        'reservations' => OpenReservationController::class,
        'employees' => EmployeeController::class,
        'games' => GameController::class,
        'games.reviews'=>GameReviewController::class, 
        'games.reviews-summary'=>GameReviewSummaryController::class,
        'categories'=>GameCategoryController::class,
        'subcategories'=>GameSubcategoryController::class,
        'schedules' => ScheduleController::class,
        'tickets' => SupportTicketController::class,
    ]);
    
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', [AuthController::class,'logout']);
        Route::get('user', [AuthController::class,'user']);
        Route::post('games\{id}\reviews', [GameReviewController::class,'store']);
    });
   
});
