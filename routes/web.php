<?php

use App\Http\Controllers\actualsController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\departmentController;
use App\Http\Controllers\indicatorsController;
use App\Http\Controllers\quartersController;
use App\Http\Controllers\reportsController;
use App\Http\Controllers\targetsController;
use App\Http\Controllers\usersController;
use App\Http\Controllers\yearController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/






// Route::get('/targets', [Controller::class, 'targets'])->name('targets');



Route::group(['middleware' => ['auth', 'pass_change']], function () {
    Route::group(['middleware' => ['admin']], function () {
        Route::post('/departments/create', [departmentController::class, 'store'])->name('create_department');
        Route::post('/departments/delete', [departmentController::class, 'destroy'])->name('delete_department');
        Route::post('/departments/update', [departmentController::class, 'update'])->name('update_department');

        Route::get('/departments', [departmentController::class, 'getDepartments'])->name('departments');


        Route::get('/years', [yearController::class, 'getYears'])->name('years');

        Route::post('/years/create', [yearController::class, 'store'])->name('create_year');
        Route::post('/year/delete', [yearController::class, 'destroy'])->name('delete_year');

        Route::post('/indicators/create', [indicatorsController::class, 'store'])->name('create_indicator');
        Route::post('/indicators/update', [indicatorsController::class, 'update'])->name('update_indicator');
        Route::post('/indicators/delete', [indicatorsController::class, 'delete'])->name('delete_indicator');
        Route::post('/indicators/setdepartment', [indicatorsController::class, 'setDepartment'])->name('setdepartment');


        Route::post('/targets/create', [targetsController::class, 'store'])->name('create_target');
        Route::post('/targets/update', [targetsController::class, 'update'])->name('update_target');
        Route::post('/targets/delete', [targetsController::class, 'delete'])->name('delete_target');
        Route::post('/quarter/year', [quartersController::class, 'setyear'])->name('set_year');
        Route::post('/quarter/create', [quartersController::class, 'store'])->name('create_quarter');
        Route::post('/quarter/update', [quartersController::class, 'update'])->name('update_quarter');
        Route::post('/quarter/delete', [quartersController::class, 'destroy'])->name('delete_quarter');
        Route::get('/users', [usersController::class, 'getUsers'])->name('users');
        Route::post('/create_users', [usersController::class, 'create_User'])->name('create_user');
        Route::post('/update_users', [usersController::class, 'update_users'])->name('update_users');

        Route::post('/actual/delete', [actualsController::class, 'delete'])->name('delete_actual');


        Route::get('/report', [reportsController::class, 'getReportData'])->name('report');
    });



    Route::get('/', [Controller::class, 'home'])->name('home');
    Route::get('/home', [Controller::class, 'home']);

    Route::post('/tagerts/indicator', [targetsController::class, 'setIndicator'])->name('set_indicator');
    Route::get('/indicators', [indicatorsController::class, 'getIndicators'])->name('indicators');
    Route::get('/targets', [targetsController::class, 'targets'])->name('targets');

    Route::post('/actual/targets', [actualsController::class, 'settarget'])->name('set_target');
    Route::get('/actuals', [actualsController::class, 'actuals'])->name('actuals');


    Route::group(['middleware' => ['usermd']], function () {

        Route::post('/actuals/create', [actualsController::class, 'store'])->name('create_actual');
    });

    Route::get('/quarter', [quartersController::class, 'getQuaters'])->name('quarter');
});


//auth routes


Route::get('/login', [AuthController::class, 'login'])->name('login');




Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/reset_password_view', [AuthController::class, 'promtChangePass'])->name('reset_password_view');

Route::post('/reset_password', [AuthController::class, 'reset_password'])->name('reset_password');

Route::get('/forgot_password', [AuthController::class, 'forget_password'])->name('forgot_password');
