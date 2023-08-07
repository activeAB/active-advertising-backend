<?php

use App\Http\Controllers\AccountManagerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FreelancerConroller;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StockController;
use App\Models\Freelancer;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

    return $request->user();
});

Route::get('/users', [UserController::class, 'index']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::post('/user', [UserController::class, 'store']);
Route::put('/user/{id}', [UserController::class, 'update']);
Route::delete('/user/{id}', [UserController::class, 'destroy']);
Route::post('/forgot', [PasswordResetController::class, 'sendResetCode']);

Route::post('/stock/add', [StockController::class, 'store']);
Route::get('/stock', [StockController::class, 'index']);
Route::put('/stock/{id}', [StockController::class, 'update']);
Route::delete('/stock/{id}', [StockController::class, 'destroy']);

Route::post('/freelancer/add', [FreelancerConroller::class, 'store']);
Route::get('/freelancer', [FreelancerConroller::class, 'index']);
Route::put('/freelancer/{id}', [FreelancerConroller::class, 'update']);
Route::delete('/freelancer/{id}', [FreelancerConroller::class, 'destroy']);
Route::get('/freelancer/{id}',[FreelancerConroller::class, 'show']);

Route::post('/account_manager/add', [AccountManagerController::class, 'store']);//it's unnecessory because there is user store
Route::get('/account_manager', [AccountManagerController::class, 'index']);
Route::put('/account_manager/{id}', [FreelancerConroller::class, 'update']);//it's unnecessory because there is user update
Route::delete('/account_manager/{id}', [FreelancerConroller::class, 'destroy']);//it's unnecessory because there is user desroy
Route::get('/account_manager/{id}',[AccountManagerController::class, 'show']);//it's unnecessory because there is user show

Route::get('/employee', [EmployeeController::class, 'index']);//it also used from employ profile
Route::get('/employee/{user_role}', [EmployeeController::class, 'staffList']);
Route::get('/employee/{user_order}/{id}', [EmployeeController::class, 'employeeOrder']);
Route::get('/order/{id}', [EmployeeController::class, 'show']);// the controller is in the employeeController