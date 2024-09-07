<?php

use App\Models\BorrowRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BorrowRecordController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(BookController::class)->group(function () {
    Route::get('/books', 'index');
    Route::get('/books/{id}', 'show');
    Route::post('/books', 'store')->middleware('auth:sanctum');
    Route::put('/books/{id}', 'update')->middleware('auth:sanctum');
    Route::delete('/books/{id}', 'destory')->middleware('auth:sanctum');
    Route::post('/books/{id}', 'return')->middleware('auth:sanctum');
    Route::post('/books/{id}', 'borrow')->middleware('auth:sanctum');
});

Route::controller(AuthorController::class)->group(function () {
    Route::get('/authors', 'index');
    Route::get('/authors/{id}', 'show');
    Route::post('/authors', 'store')->middleware('auth:sanctum');
    Route::put('/authors/{id}', 'update')->middleware('auth:sanctum');
    Route::delete('/authors/{id}', 'destory')->middleware('auth:sanctum');
    
});

Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index');
    Route::get('/users/{id}', 'show');
    Route::post('/users/register', 'store');
    Route::put('/users/{id}', 'update');
    Route::delete('/users/{id}', 'destory');
    Route::post('/users/login', 'loginUser');
    
});

Route::controller(BorrowRecordController::class)->group(function () {
    Route::get('/borrow-records', 'index')->middleware('auth:sanctum');
    Route::get('/borrow-records/{id}', 'show')->middleware('auth:sanctum');
    
    
});

