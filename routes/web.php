<?php

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

Route::get('/', function () {
    return 'api-easyjus';
});

Route::group(['prefix' => 'api/v1'], function () {
    Route::group(['prefix' => 'frontend'], function () {
        Route::group(['prefix' => 'admin-users'], function() {
            Route::post('/', [App\Http\Controllers\AdminUsersController::class, 'store']);
            Route::post('/verify-email', [App\Http\Controllers\AdminUsersController::class, 'verifyEmail']);
            Route::post('/get-by-email', [App\Http\Controllers\AdminUsersController::class, 'getByEmail']);
            Route::post('/get-recovery-password-token', [App\Http\Controllers\AdminUsersController::class, 'getRecoveryPasswordToken']);
            Route::post('/get-user-by-token', [App\Http\Controllers\AdminUsersController::class, 'getUserByToken']);
            Route::post('/change-password', [App\Http\Controllers\AdminUsersController::class, 'changePassword']);
            Route::post('/edit/{id}', [App\Http\Controllers\AdminUsersController::class, 'changeAdminUser']);
            Route::post('/search', [App\Http\Controllers\AdminUsersController::class, 'search']);
            Route::post('/delete/{id}', [App\Http\Controllers\AdminUsersController::class, 'destroy']);
            Route::post('/block/{id}', [App\Http\Controllers\AdminUsersController::class, 'blockAdminUser']);

            Route::group(['prefix' => 'password'], function() {
                Route::post('/check', [App\Http\Controllers\AdminUserPasswordController::class, 'checkPassword']);
                Route::post('/change', [App\Http\Controllers\AdminUserPasswordController::class, 'changePassword']);
            });
        });

        Route::group(['prefix' => 'students'], function() {
            Route::post('/', [App\Http\Controllers\StudentsController::class, 'store']);
            Route::post('/search', [App\Http\Controllers\StudentsController::class, 'search']);
            Route::post('/delete/{id}', [App\Http\Controllers\StudentsController::class, 'destroy']);
            Route::post('/edit/{id}', [App\Http\Controllers\StudentsController::class, 'edit']);
            Route::post('/get-recovery-password-token', [App\Http\Controllers\StudentsController::class, 'getRecoveryPasswordToken']);
            Route::post('/block/{id}', [App\Http\Controllers\StudentsController::class, 'blockStudent']);
        });

        Route::group(['prefix' => 'subjects'], function() {
            Route::post('/search', [App\Http\Controllers\SubjectsController::class, 'search']);
            Route::post('/search-with-study-object', [App\Http\Controllers\SubjectsController::class, 'searchWithStudyObject']);
            Route::post('/', [App\Http\Controllers\SubjectsController::class, 'store']);
            Route::post('/delete/{id}', [App\Http\Controllers\SubjectsController::class, 'destroy']);
            Route::post('/edit-subject/{id}', [App\Http\Controllers\SubjectsController::class, 'edit']);
        });

        Route::group(['prefix' => 'study-objects'], function() {
            Route::post('/search', [App\Http\Controllers\StudyObjectsController::class, 'search']);
            Route::post('/', [App\Http\Controllers\StudyObjectsController::class, 'store']);
            Route::post('/edit/{id}', [App\Http\Controllers\StudyObjectsController::class, 'edit']);
            Route::post('/delete/{id}', [App\Http\Controllers\StudyObjectsController::class, 'destroy']);
            Route::post('/get-from-subject/{subjectId}', [App\Http\Controllers\StudyObjectsController::class, 'getFromSubjectId']);
        });

        Route::group(['prefix' => 'questions'], function() {
            Route::post('/search', [App\Http\Controllers\QuestionsController::class, 'search']);
            Route::post('/', [App\Http\Controllers\QuestionsController::class, 'store']);
            Route::post('/destroy/{id}', [App\Http\Controllers\QuestionsController::class, 'destroy']);
            Route::post('/edit/{id}', [App\Http\Controllers\QuestionsController::class, 'edit']);
        });

        Route::group(['prefix' => 'options'], function() {
            Route::post('/get-from-question/{questionId}', [App\Http\Controllers\OptionsController::class, 'getFromQuestionId']);
            Route::post('/', [App\Http\Controllers\OptionsController::class, 'store']);
            Route::delete('/{id}', [App\Http\Controllers\OptionsController::class, 'destroy']);
            Route::put('/{id}', [App\Http\Controllers\OptionsController::class, 'edit']);
        });

        Route::group(['prefix' => 'modules'], function() {
            Route::post('/', [App\Http\Controllers\ModulesController::class, 'store']);
            Route::get('/', [App\Http\Controllers\ModulesController::class, 'listModules']);
            Route::patch('/{id}', [App\Http\Controllers\ModulesController::class, 'edit']);
            Route::post('/{id}', [App\Http\Controllers\ModulesController::class, 'getById']);
            Route::delete('/{id}', [App\Http\Controllers\ModulesController::class, 'destroy']);
            Route::post('/allowed-modules/{userId}', [App\Http\Controllers\ModulesController::class, 'getAllowedModules']);
        });

        Route::group(['prefix' => 'menus'], function() {
            Route::post('/', [App\Http\Controllers\MenusController::class, 'store']);
            Route::get('/', [App\Http\Controllers\MenusController::class, 'listMenus']);
            Route::patch('/{id}', [App\Http\Controllers\MenusController::class, 'edit']);
            Route::post('/{id}', [App\Http\Controllers\MenusController::class, 'getById']);
            Route::delete('/{id}', [App\Http\Controllers\MenusController::class, 'destroy']);
        });

        Route::group(['prefix' => 'admin-modules'], function() {
            Route::post('/', [App\Http\Controllers\AdminUsersModulesController::class, 'store']);
            Route::get('/', [App\Http\Controllers\AdminUsersModulesController::class, 'listAll']);
            Route::patch('/{id}', [App\Http\Controllers\AdminUsersModulesController::class, 'edit']);
            Route::post('/{id}', [App\Http\Controllers\AdminUsersModulesController::class, 'getById']);
            Route::delete('/{id}', [App\Http\Controllers\AdminUsersModulesController::class, 'destroy']);
        });

        Route::group(['prefix' => 'admin-menus'], function() {
            Route::post('/', [App\Http\Controllers\AdminUsersMenusController::class, 'store']);
            Route::get('/', [App\Http\Controllers\AdminUsersMenusController::class, 'listAll']);
            Route::patch('/{id}', [App\Http\Controllers\AdminUsersMenusController::class, 'edit']);
            Route::post('/{id}', [App\Http\Controllers\AdminUsersMenusController::class, 'getById']);
            Route::delete('/{id}', [App\Http\Controllers\AdminUsersMenusController::class, 'destroy']);
        });

        Route::group(['prefix' => 'auth'], function() {
            Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
        });
    });


});
