<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HistoryController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\EmployeeMiddleware;



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


// This route is excluded from the 'admin' middleware group
Route::post('/auth-admin', [AuthController::class, 'adminLogin']);
Route::post('/auth-employee', [AuthController::class, 'employeeLogin']);
Route::put('/employee/validate/{token}', [EmployeeController::class, 'validateProfile']);
Route::get('/employee/check-invitation/{token}', [InvitationController::class, 'checkInvitation']);
Route::post('/admins/invite', [AdminController::class, 'inviteEmployee']);



Route::middleware([AdminMiddleware::class])->group(function () {
    Route::get('/admins', [AdminController::class, 'index']);
    Route::post('/admins', [AdminController::class, 'store']);
    Route::get('/admins/{id}', [AdminController::class, 'show']);
    Route::put('/admins/{id}', [AdminController::class, 'update']);
    Route::delete('/admins/{id}', [AdminController::class, 'destroy']);
    Route::get('/admin/companies', [CompanyController::class, 'index']);
    Route::post('/admin/companies', [CompanyController::class, 'store']);
    Route::get('/admin/companies/{id}', [CompanyController::class, 'show']);
    Route::put('/admin/companies/{id}', [CompanyController::class, 'update']);
    Route::delete('/admin/companies/{id}', [CompanyController::class, 'destroy']);
    Route::get('/admin/dashboard', [DashboardController::class, 'index']);
    Route::get('/admin/histories', [HistoryController::class, 'index']);
    Route::get('/admin/invitations', [InvitationController::class, 'index']);
    Route::delete('/admin/invitations/{id}', [InvitationController::class, 'destroy']);
});

Route::middleware([EmployeeMiddleware::class])->group(function () {
    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::post('/employees', [EmployeeController::class, 'store']);
    Route::get('/employee/', [EmployeeController::class, 'show']);
    Route::put('/employee/', [EmployeeController::class, 'update']);
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);
    Route::get('/employee/company/', [CompanyController::class, 'showByUser']);
});