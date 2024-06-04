<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;


Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/book/detail/{id}',[HomeController::class,'book_detail'])->name('book.detail');
Route::post('/book/review',[HomeController::class,'book_review'])->name('book.review');



Route::group(['prefix'=>'account'],function()
{

    Route::group(['middleware'=>'guest'],function()
    {
        Route::get('/register',[AccountController::class,'show_register'])->name('accounts.register');
        Route::post('/register',[AccountController::class,'store_register'])->name('accounts.store_register');
        Route::get('/login',[AccountController::class,'show_login'])->name('accounts.login');
        Route::post('/login',[AccountController::class,'store_login'])->name('accounts.store_login');
    });

    Route::group(['middleware'=>'auth'],function()
    {
        Route::get('/profile',[AccountController::class,'profile'])->name('accounts.profile');
        Route::post('/profile',[AccountController::class,'profile_update'])->name('accounts.profile_update');
        Route::get('/logout',[AccountController::class,'logout'])->name('accounts.logout');

        // Books
        Route::get('/books',[BookController::class,'index'])->name('books.index');
        Route::get('/books/create',[BookController::class,'create'])->name('books.create');
        Route::post('/books/create',[BookController::class,'store'])->name('books.store');
        Route::get('/books/edit/{id}',[BookController::class,'edit'])->name('books.edit');
        Route::put('/books/{id}',[BookController::class,'update'])->name('books.update');
        Route::delete('/books/{id}',[BookController::class,'destroy'])->name('books.destroy');

        //Review
        Route::get('/review',[ReviewController::class,'index'])->name('reviews');
        Route::get('/review/{id}/edit',[ReviewController::class,'edit'])->name('reviews.edit');
        Route::put('/review/{id}',[ReviewController::class,'update'])->name('reviews.update');
        Route::delete('/review/{id}',[ReviewController::class,'destroy'])->name('reviews.destroy');

    });


});
