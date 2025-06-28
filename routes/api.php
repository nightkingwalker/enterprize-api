<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ClientEmployeeController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ProjectFileController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\SegmentController;
use App\Http\Controllers\Api\TranslationMemoryController;
use App\Http\Controllers\Api\DeliverableController;
use App\Http\Controllers\Api\AuthController;

Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});
Route::prefix('v1.24')->group(function () {
    // Authentication routes
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register']);
    // Route::get('me', [AuthController::class, 'me'])->name('me');


    // Resource routes
    Route::middleware('auth:api')->group(
        function () {
            Route::post('logout', [AuthController::class, 'logout'])->name('logout');
            Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
            Route::get('me', [AuthController::class, 'me'])->name('me');
            Route::apiResources([
                'users' => UserController::class,
                'clients' => ClientController::class,
                'client-employees' => ClientEmployeeController::class,
                'projects' => ProjectController::class,
                'project-files' => ProjectFileController::class,
                'tasks' => TaskController::class,
                'segments' => SegmentController::class,
                'translation-memories' => TranslationMemoryController::class,
                'deliverables' => DeliverableController::class,
            ]);

            // Additional custom routes
            Route::get('projects/{project}/tasks', [ProjectController::class, 'projectTasks']);
            Route::get('tasks/{task}/segments', [TaskController::class, 'taskSegments']);
        }
    );
});
