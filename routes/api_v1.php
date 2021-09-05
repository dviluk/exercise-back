<?php

use App\Http\Controllers\API\V1\Admin\DifficultiesController;
use App\Http\Controllers\API\V1\Admin\EquipmentController;
use App\Http\Controllers\API\V1\Admin\ExerciseGroupsController;
use App\Http\Controllers\API\V1\Admin\GoalsController;
use App\Http\Controllers\API\V1\Admin\MusclesController;
use App\Http\Controllers\API\V1\Admin\PlansController;
use App\Http\Controllers\API\V1\Admin\TagsController;
use App\Http\Controllers\API\V1\Admin\UnitsController;
use App\Http\Controllers\API\V1\Admin\UsersController;
use App\Http\Controllers\API\V1\Admin\ExercisesController;
use App\Http\Controllers\API\V1\AuthController;
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

    Route::post('exercises/{exercise}/attach/equipment', [ExercisesController::class, 'attachEquipment']);
    Route::post('exercises/{exercise}/detach/equipment', [ExercisesController::class, 'detachEquipment']);
    Route::post('exercises/{exercise}/detach-all/equipment', [ExercisesController::class, 'detachAllEquipment']);

    Route::post('exercises/{exercise}/attach/muscles', [ExercisesController::class, 'attachMuscles']);
    Route::post('exercises/{exercise}/detach/muscles', [ExercisesController::class, 'detachMuscles']);
    Route::post('exercises/{exercise}/detach-all/muscles', [ExercisesController::class, 'detachAllMuscles']);

    Route::resource('exercise-groups', ExerciseGroupsController::class);
    Route::resource('exercises', ExercisesController::class);

    Route::resource('plans', PlansController::class);

    Route::resource('tags', TagsController::class);
});


Route::fallback(function () {
    return API::response404();
});
