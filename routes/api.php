<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Controller;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/profile', [AuthController::class, 'profile']);

    Route::post('/add-type', [AdminController::class, 'add_type']);
    Route::post('/add-document', [AdminController::class, 'add_document']);
    Route::post('/add-accounting', [AdminController::class, 'add_accounting']);
    Route::post('/add-answer', [AdminController::class, 'add_answer']);
    Route::get('/get-users',[AdminController::class, 'get_users']);
    
    Route::post('/add-application', [ApplicationController::class, 'add_application']);
    Route::get('/get-applications', [ApplicationController::class, 'get_application']);
    Route::get('/find-applications', [ApplicationController::class, 'find_application']);
    Route::get('/get-one-application/{id}',[ApplicationController::class, 'get_one_application']);
    Route::get('/get-answer/{id}', [ApplicationController::class, 'get_answer']);

    Route::get('/get-accountings', [AccountController::class, 'get_accountings']);
    Route::get('/get-accounting/{id}', [AccountController::class, 'get_one_accounting']);
    Route::post('/change-status/{id}', [AccountController::class, 'change_status']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/get-types', [AdminController::class, 'get_types']);
Route::get('/get-documents', [DocumentController::class, 'get_documents']);
Route::get('/find-documents', [DocumentController::class, 'find_documents']);
