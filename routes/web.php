<?php

use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\EmployeeController;
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
    Route::get('/', function () { return view('home');});//index page
    //employee page
    Route::resource('employee', EmployeeController::class);
    Route::get('employee/create', [EmployeeController::class, 'createView']);//create employee
    Route::post('employee/create', [EmployeeController::class, 'store']);//store employee

    Route::post('/logout', [AuthUserController::class, 'logout']);// user logout
});

Route::middleware('guest')->group(function(){
    //user
    Route::get('/login', [AuthUserController::class, 'login'])->name('login');//show login page
    Route::post('/login', [AuthUserController::class, 'post_login']);//show login page

    Route::get('/register', [AuthUserController::class, 'register']);//show register page
    Route::post('/register', [AuthUserController::class, 'store']);//store user data
});
