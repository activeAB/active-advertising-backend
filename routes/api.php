<?php


use App\Http\Controllers\Basic_infoController;

use App\Http\Controllers\AccountManagerController;
use App\Http\Controllers\AgreementController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FreelancerConroller;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ProformaController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\WeeklyReportController;


use App\Models\Basic_info;
use App\Models\Freelancer;
use App\Models\Order;
use App\Models\Role;
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

Route::middleware('auth:sanctum')->get('/user/verify', function () {
    if (!auth()->user()) {
        return response()->json([
            'message' => "unauthorized user"
        ], 401);
    }
    return auth()->user();
});


Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);

    Route::post('/user', [UserController::class, 'store']);
    Route::post('/forgot', [PasswordResetController::class, 'sendResetCode']);
    Route::get('/user/email/{email}', [UserController::class, 'userFind']);

    // Not done
    Route::post('/stock/add', [StockController::class, 'store']);
    Route::get('/stock', [StockController::class, 'index']);
    Route::put('/stock/{id}', [StockController::class, 'update']);
    Route::delete('/stock/{id}', [StockController::class, 'destroy']);

    Route::post('/freelancer/add', [FreelancerConroller::class, 'store']);
    Route::get('/freelancer', [FreelancerConroller::class, 'index']);
    Route::put('/freelancer/{id}', [FreelancerConroller::class, 'update']);
    Route::delete('/freelancer/{id}', [FreelancerConroller::class, 'destroy']);


    Route::get('/basic_info', [Basic_infoController::class, 'index']);
    Route::post('/basic_info', [Basic_infoController::class, 'store']);
    Route::put('/basic_info/{id}', [Basic_infoController::class, 'update']);
    Route::get('/freelancer/{id}', [FreelancerConroller::class, 'show']);

    Route::get('/account_manager', [AccountManagerController::class, 'index']);
    Route::get('/employee', [EmployeeController::class, 'index']); //it also used from employ profile
    Route::get('/employee/{user_role}', [EmployeeController::class, 'staffList']);
    Route::get('/employee/{user_order}/{id}', [EmployeeController::class, 'employeeOrder']); //it shows the order that is assigned right now and there status is allocated not both unallocated and done
    Route::get('/employeeAllOrder/{user_order}/{id}', [EmployeeController::class, 'employeeAllOrder']); //it shows the all history of order that assigned to the employer
    // Route::get('/order/{id}', [EmployeeController::class, 'show']); // the controller is in the employeeController
    Route::get('/order/employer/{id}', [OrderController::class, 'employer']); //route for which user that the order is assigned
    Route::get('/employeeList/staff', [EmployeeController::class, 'employeeListStaff']);
    Route::get('/employeeList/freelancer', [EmployeeController::class, 'employeeListFreelancer']);
    Route::get('/agreement/{id}', [AgreementController::class, 'show']);

    // done
    Route::get('/proforma', [ProformaController::class, 'index']);
    Route::post('/proforma/add', [ProformaController::class, 'store']);
    Route::get('/proforma/{id}', [ProformaController::class, 'show']);
    Route::put('/proforma/{id}', [ProformaController::class, 'update']);
    Route::delete('/proforma/{id}', [ProformaController::class, 'destroy']);

    Route::get('/order/{id}', [OrderController::class, 'show']);
    Route::put('/orderStaff', [OrderController::class, 'updateStaff']);
    Route::put('/orderFreelancer', [OrderController::class, 'updateFreelancer']);
    Route::delete('/order/{id}', [OrderController::class, 'destroy']);
    Route::get('/order', [OrderController::class, 'index']);


    Route::post('/role/add', [RoleController::class, 'store']);
    Route::get('/role', [RoleController::class, 'index']);
    Route::put('/role/{id}', [RoleController::class, 'update']);
    Route::delete('/role/{id}', [RoleController::class, 'destroy']);


    // Route::get('/generate-report', [WeeklyReportController::class, 'generateReport']);
    Route::get('/report/{day}', [WeeklyReportController::class, 'show']);
    Route::get('/report', [WeeklyReportController::class, 'index']);
});

// done
Route::get('/test_active', function(){
    return "DOne..";
});

Route::post('/login', [UserController::class, 'login']);
Route::post('/forgot', [PasswordResetController::class, 'sendResetCode']);
Route::post('/verifyCode', [PasswordResetController::class, 'checkCode']);
Route::post('/changePassword', [PasswordResetController::class, 'changePassword']);

Route::get('/employeeList', [EmployeeController::class, 'employeeListStaff']);