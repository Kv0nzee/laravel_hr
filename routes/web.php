<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\UserController;
use App\Models\CompanySetting;
use Illuminate\Support\Facades\Route;
use Laragear\WebAuthn\WebAuthn;

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

WebAuthn::routes();

Route::middleware('auth')->group(function(){
    Route::get('/', [UserController::class, 'index']);//index page
    Route::get('/profile/{name}', [UserController::class, 'profile'])->middleware('permission:view profile');//profile page
    Route::get('/checkincheckout', [ScannerController::class, 'checkin']);//checkin page
    Route::post('/checkincheckout', [ScannerController::class, 'checkPinCode']);//validate checkin
    Route::get('/qrscanner', [ScannerController::class, 'qrscanner']);//qr scanner
    Route::post('/qrscannerValid', [ScannerController::class, 'qrStore']);//qr scanner

    //company setting page
    Route::resource('company_setting', CompanySettingController::class)->middleware('permission:view company_setting');//company_setting table
    Route::get('/company_setting/{id}/edit', [CompanySettingController::class, 'edit'])->middleware('permission:edit company_settings');  // edit company_setting
    Route::patch('/company_setting/{id}/update', [CompanySettingController::class, 'update'])->middleware('permission:edit company_setting');  // update company_setting

    //employee page
    Route::resource('employee', EmployeeController::class)->middleware('permission:view employees');//employee table
    Route::get('employee/create', [EmployeeController::class, 'createView'])->middleware('permission:create employees');//create employee
    Route::post('employee/create', [EmployeeController::class, 'store'])->middleware('permission:create employees');//store employee
    Route::get('/employee/{id}/info', [EmployeeController::class, 'show']);// employee detail
    Route::get('/employee/{id}/edit', [EmployeeController::class, 'edit'])->middleware('permission:edit employees');  // edit employee
    Route::patch('/employee/{id}/update', [EmployeeController::class, 'update'])->middleware('permission:edit employees');  // update employee
    Route::delete('/employee/{id}/delete', [EmployeeController::class, 'delete'])->middleware('permission:delete employees'); // delete employee

    //department page
    Route::resource('department', DepartmentController::class)->middleware('permission:view departments');//department table
    Route::get('department/create', [DepartmentController::class, 'createView'])->middleware('permission:create departments');//create department
    Route::post('department/create', [DepartmentController::class, 'store'])->middleware('permission:create departments');//store department
    Route::get('/department/{id}/edit', [DepartmentController::class, 'edit'])->middleware('permission:edit departments');  // edit department
    Route::patch('/department/{id}/update', [DepartmentController::class, 'update'])->middleware('permission:edit departments');  // update department
    Route::delete('/department/{id}/delete', [DepartmentController::class, 'delete'])->middleware('permission:delete departments');  // delete department

    //role page
    Route::resource('role', RoleController::class)->middleware('permission:view roles');//role table
    Route::get('role/create', [RoleController::class, 'createView'])->middleware('permission:create roles');//create role
    Route::post('role/create', [RoleController::class, 'store'])->middleware('permission:create roles');//store role
    Route::get('/role/{id}/edit', [RoleController::class, 'edit'])->middleware('permission:edit roles');  // edit role
    Route::patch('/role/{id}/update', [RoleController::class, 'update'])->middleware('permission:edit roles');  // update role
    Route::delete('/role/{id}/delete', [RoleController::class, 'delete'])->middleware('permission:delete roles');  // delete role

    //permission page
    Route::resource('permission', PermissionController::class)->middleware('permission:view permissions');//permission table
    Route::get('permission/create', [PermissionController::class, 'createView'])->middleware('permission:create permissions');//create permission
    Route::post('permission/create', [PermissionController::class, 'store'])->middleware('permission:create permissions');//store permission
    Route::get('/permission/{id}/edit', [PermissionController::class, 'edit'])->middleware('permission:edit permissions');  // edit permission
    Route::patch('/permission/{id}/update', [PermissionController::class, 'update'])->middleware('permission:edit permissions');  // update permission
    Route::delete('/permission/{id}/delete', [PermissionController::class, 'delete'])->middleware('permission:delete permissions');  // delete role

    //attendance page
    Route::get('attendanceOverview', [AttendanceController::class, 'overview'])->middleware('permission:attendance overview');//employees attendacne overview
    Route::get('attendanceOverviewtable/{year?}/{month?}', [AttendanceController::class, 'overviewTable'])->middleware('permission:attendance overview');//employees attendacne overview
    Route::resource('attendance', AttendanceController::class)->middleware('permission:view attendance');//attendance table
    Route::get('attendance/create', [AttendanceController::class, 'createView'])->middleware('permission:create attendance');//create attendance
    Route::post('attendance/create', [AttendanceController::class, 'store'])->middleware('permission:create attendance');//store attendance
    Route::get('/attendance/{id}/edit', [AttendanceController::class, 'edit'])->middleware('permission:edit attendance');  // edit attendance
    Route::patch('/attendance/{id}/update', [AttendanceController::class, 'update'])->middleware('permission:edit attendance');  // update attendance
    Route::delete('/attendance/{id}/delete', [AttendanceController::class, 'delete'])->middleware('permission:delete attendance');  // delete role

    Route::post('/logout', [AuthUserController::class, 'logout']);// user logout
});

Route::middleware('guest')->group(function(){
    //user
    Route::get('/login', [AuthUserController::class, 'login'])->name('login');//show login page
    Route::post('/login', [AuthUserController::class, 'post_login']);//show login page

    Route::get('/register', [AuthUserController::class, 'register']);//show register page
    Route::post('/register', [AuthUserController::class, 'store']);//store user data
});
