<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BorrowRecordController;


Route::post('/users/register', [UserController::class,'store'])->middleware('throttle:10,1');
Route::post('/users/login', [UserController::class, 'loginUser'])->middleware('throttle:10,1');

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(BookController::class)->group(function () {
        Route::middleware(['role:Admin, Librarian', 'throttle:10,1'])->group(function () {
            Route::post('/books/create', 'store');  // Only Admin can create books
            Route::put('/books/{id}/update', 'update');
        });
        Route::middleware(['role:Admin','throttle:10,1'])->group(function (){
            Route::delete('/books/{id}/delete', 'destory');
         });
    
         Route::middleware(['role:member','throttle:10,1'])->group(function (){
            Route::post('/books/{id}/return', 'return');
            Route::post('/books/{id}/borrow', 'borrow');
         });
    
        Route::get('/books', 'index');
        Route::get('/books/{id}', 'show');
        Route::get('/books/search', 'search'); 
    });

    Route::controller(AuthorController::class)->group(function () {
        Route::middleware(['role:Admin, Librarian','throttle:10,1'])->group(function () {
            Route::post('/authors/create', 'store');
            Route::put('/authors/{id}/update', 'update');
        });
    
        Route::middleware(['role:Admin','throttle:10,1'])->group(function (){
            Route::delete('/authors/{id}/delete', 'destory');
         });
    
        Route::get('/authors', 'index');
        Route::get('/authors/{id}', 'show');  
    });
    
    Route::controller(UserController::class)->group(function () {
        Route::middleware(['role:Admin', 'throttle:10,1'])->group(function (){
            Route::get('/users', 'index');
            Route::get('/users/{id}', 'show');
            Route::delete('/users/{id}/delete', 'destory');
         });
         Route::middleware(['role:Admin, Librarian', 'throttle:10,1'])->group(function () {
            Route::put('/users/{id}/update', 'update'); 
        });
        
        
    });
    
    Route::controller(BorrowRecordController::class)->group(function () {
        Route::middleware(['role:Admin, Librarian','throttle:10,1'])->group(function () {
        Route::get('/borrow-records', 'index');
        Route::get('/borrow-records/{id}', 'show');  
        });

        Route::middleware(['role:Admin, Librarian', 'throttle:10,1'])->group(function () {
            Route::post('/borrow-records/create', 'store');
            Route::put('/borrow-records/{id}/update', 'update');  
            });
          
    });
    
});


