<?php

use App\Http\Controllers\API\V1\Admin\DifficultiesController;
use App\Http\Controllers\API\V1\Admin\EquipmentController;
use App\Http\Controllers\API\V1\Admin\GoalsController;
use App\Http\Controllers\API\V1\Admin\MusclesController;
use App\Http\Controllers\API\V1\Admin\PlansController;
use App\Http\Controllers\API\V1\Admin\RoutinesController;
use App\Http\Controllers\API\V1\Admin\TagsController;
use App\Http\Controllers\API\V1\Admin\UnitsController;
use App\Http\Controllers\API\V1\Admin\UsersController;
use App\Http\Controllers\API\V1\Admin\WorkoutsController;
use App\Http\Controllers\API\V1\AuthController;
use App\Utils\API;
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

Route::get('/', function () {
    return API::response200([
        'message' => 'Welcome to Exercise API V1!'
    ]);
});

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/me', [AuthController::class, 'me']);

    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // ONLY ADMIN
    Route::group([], function () {
        Route::resource('users', UsersController::class);
        Route::resource('units', UnitsController::class);
        Route::resource('difficulties', DifficultiesController::class);
        Route::resource('goals', GoalsController::class);
        Route::resource('equipment', EquipmentController::class);
        Route::resource('muscles', MusclesController::class);
    });

    Route::post('workouts/{workout}/attach/equipment', [WorkoutsController::class, 'attachEquipment']);
    Route::post('workouts/{workout}/detach/equipment', [WorkoutsController::class, 'detachEquipment']);
    Route::post('workouts/{workout}/detach-all/equipment', [WorkoutsController::class, 'detachAllEquipment']);

    Route::post('workouts/{workout}/attach/muscles', [WorkoutsController::class, 'attachMuscles']);
    Route::post('workouts/{workout}/detach/muscles', [WorkoutsController::class, 'detachMuscles']);
    Route::post('workouts/{workout}/detach-all/muscles', [WorkoutsController::class, 'detachAllMuscles']);

    Route::resource('workouts', WorkoutsController::class);

    Route::post('routines/{routine}/attach/workouts', [RoutinesController::class, 'attachWorkouts']);
    Route::post('routines/{routine}/detach/workouts', [RoutinesController::class, 'detachWorkouts']);
    Route::post('routines/{routine}/detach-all/workouts', [RoutinesController::class, 'detachAllWorkouts']);

    Route::resource('routines', RoutinesController::class);

    Route::resource('plans', PlansController::class);

    Route::resource('tags', TagsController::class);
});
