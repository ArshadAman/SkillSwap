<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserAction;

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');
Route::get('/', [UserAction::class,'index'])->name('dashboard');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.user');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.user');
Route::get('/logout', [AuthController::class,'logout'])->name("logout");

// Skills Route
Route::post('/add-skill', [UserAction::class, 'addSkill'])->name('add-skill');
Route::post('/delete-skill', [UserAction::class, 'deleteSkill'])->name('delete-skill');