<?php

use App\Http\Controllers\AuthUserController;
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

Route::get('/', function () { return view('home');});

//user
Route::get('/login', [AuthUserController::class, 'login']);//show login page
Route::post('/login', [AuthUserController::class, 'post_login']);//show login page


Route::get('/register', [AuthUserController::class, 'register']);//show register page
Route::post('/register', [AuthUserController::class, 'store']);//store user data

Route::post('/logout', [AuthUserController::class, 'logout']);//logout