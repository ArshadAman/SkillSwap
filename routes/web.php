<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserAction;

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');
Route::get('/', [UserAction::class,'index'])->name('dashboard')->middleware('custom.auth');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.user');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.user');
Route::get('/logout', [AuthController::class,'logout'])->name("logout");

// Skills Route
Route::post('/add-skill', [UserAction::class, 'addSkill'])->name('add-skill')->middleware('custom.auth');
Route::post('/delete-skill', [UserAction::class, 'deleteSkill'])->name('delete-skill')->middleware('custom.auth');

// Skill Request Route
Route::post('/send-request/{userId}', [UserAction::class, 'sendRequest'])->name('send-request')->middleware('custom.auth');
Route::get('/view-sent-request', [UserAction::class, 'getSentRequests'])->name('view_sent_request')->middleware('custom.auth');
Route::get('/view-recieved-request', [UserAction::class,'getRecievedRequest'])->name("view_recieved_request")->middleware('custom.auth');
Route::post('/delete-skill-request/{request_id}', [UserAction::class, 'destroySkillRequest'])->name('delete_skill_request')->middleware('custom.auth'); 
Route::post('/update-status/{skillId}',[UserAction::class,'updateSkillRequest'])->name("update_skill_request")->middleware('custom.auth');
Route::get('/view-accepted', [UserAction::class,'viewAccepted'])->name("view_accepted")->middleware('custom.auth');