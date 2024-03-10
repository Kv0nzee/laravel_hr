<?php

use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth')->group(function(){
    Route::get('/', [UserController::class, 'index']);//index page
    Route::get('/profile/{name}', [UserController::class, 'profile']);//profile page

    //employee page
    Route::resource('employee', EmployeeController::class);//employee table
    Route::get('employee/create', [EmployeeController::class, 'createView']);//create employee
    Route::post('employee/create', [EmployeeController::class, 'store']);//store employee
    Route::get('/employee/{id}/info', [EmployeeController::class, 'show']);  // employee detail
    Route::get('/employee/{id}/edit', [EmployeeController::class, 'edit']);  // edit employee
    Route::patch('/employee/{id}/update', [EmployeeController::class, 'update']);  // update employee
    Route::delete('/employee/{id}/delete', [EmployeeController::class, 'delete']);  // delete employee

    //department page
    Route::resource('department', DepartmentController::class);//department table
    Route::get('department/create', [DepartmentController::class, 'createView']);//create department
    Route::post('department/create', [DepartmentController::class, 'store']);//store department
    Route::get('/department/{id}/edit', [DepartmentController::class, 'edit']);  // edit department
    Route::patch('/department/{id}/update', [DepartmentController::class, 'update']);  // update department
    Route::delete('/department/{id}/delete', [DepartmentController::class, 'delete']);  // delete department


    Route::post('/logout', [AuthUserController::class, 'logout']);// user logout
});

Route::middleware('guest')->group(function(){
    //user
    Route::get('/login', [AuthUserController::class, 'login'])->name('login');//show login page
    Route::post('/login', [AuthUserController::class, 'post_login']);//show login page

    Route::get('/register', [AuthUserController::class, 'register']);//show register page
    Route::post('/register', [AuthUserController::class, 'store']);//store user data
});
