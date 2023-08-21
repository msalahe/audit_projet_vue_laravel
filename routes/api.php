<?php

use Illuminate\Http\Request;
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

 Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(App\Http\Controllers\Api\ProjectUserController::class)->group(function () {
    Route::get('/audits/{auditProject}/users', 'getUsers');
    Route::post('/audits/{auditProject}/users', 'syncUsers');
    Route::delete('/audits/{auditProject}/users/{userId}', 'destroy');
});

Route::controller(App\Http\Controllers\Api\AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(App\Http\Controllers\Api\AuditController::class)->group(function () {
        Route::get('/audits/{auditProject}', 'show');
        Route::get('/audits', 'index');
        Route::post('/audits', 'store');
        Route::post('/audits/{auditProject}', 'update');

        Route::get('/me/audits', 'me');
        Route::get('/lead/audits', 'lead')->middleware('role:Auditor');
    });

    Route::controller(App\Http\Controllers\Api\ProjectQAController::class)->group(function () {
        Route::get('/audits/{auditProject}/qas', 'index');
        Route::post('/audits/{auditProject}/qas', 'store');
        Route::post('/audits/{auditProject}/qas/{QaId}', 'update');
        Route::delete('/audits/{auditProject}/qas/{QaId}', 'destroy');
    });

    Route::controller(App\Http\Controllers\Api\ProjectBestPracticeController::class)->group(function () {
        Route::get('/audits/{auditProject}/bps', 'index');
        Route::get('/audits/{auditProject}/bps/me', 'me');
        Route::post('/audits/{auditProject}/bps', 'store');
        Route::post('/audits/{auditProject}/bps/{bestPractice}/status', 'updateStatus');
        Route::post('/audits/{auditProject}/bps/{bestPractice}/ready', 'updateState');
        Route::post('/audits/{auditProject}/bps/{bestPractice}', 'update');
        Route::delete('/audits/{auditProject}/bps/{bestPractice}', 'destroy');
    });

    Route::controller(App\Http\Controllers\Api\ProjectScopeController::class)->group(function () {
        Route::get('/audits/{auditProject}/scopes ',  'getScopes');
        Route::post('/audits/{auditProject}/scopes ', 'store');
        Route::post('/audits/{auditProject}/scopes/{scope} ', 'update');
        Route::delete('/audits/{auditProject}/scopes/{scope} ', 'destroy');

    });

    Route::controller(App\Http\Controllers\Api\ProjectTestController::class)->group(function () {
        Route::get('/audits/{auditProject}/tests ',  'index');
        Route::post('/audits/{auditProject}/tests ', 'store');
    });

    Route::controller(App\Http\Controllers\Api\ProjectTestScenarioController::class)->group(function () {
        Route::post('/audits/{auditProject}/tests_scenarios/batch ',  'update');
        Route::post('/audits/{auditProject}/tests_scenarios/new ',  'store');
    });

 


    Route::controller(App\Http\Controllers\Api\BlockchainController::class)->prefix('blockchains')->group(function () {
        Route::get('/', 'index');
    });

    Route::controller(App\Http\Controllers\Api\CategoryController::class)->prefix('categories')->group(function () {
        Route::get('/', 'index');
    });

    Route::controller(App\Http\Controllers\Api\IssueController::class)->prefix('issues')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{id}', 'show');
        Route::post('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    Route::controller(App\Http\Controllers\Api\RoleController::class)->prefix('roles')->group(function () {
        Route::get('/', 'index');
    });

    Route::controller(App\Http\Controllers\Api\SkillController::class)->prefix('skills')->group(function () {
        Route::get('/', 'index');
    });

    Route::controller(App\Http\Controllers\Api\StatusController::class)->prefix('statuses')->group(function () {
        Route::get('/', 'index');
    });

    Route::controller(App\Http\Controllers\Api\TagController::class)->prefix('tags')->group(function () {
        Route::get('/', 'index');
    });

    Route::controller(App\Http\Controllers\Api\UserController::class)->prefix('users')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{id}', 'show');
        Route::post('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });
});
