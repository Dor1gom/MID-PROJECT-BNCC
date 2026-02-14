<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\BorrowingDetailController;

Route::get('/', function () {
    return view('welcome');
});

// Routes untuk Books
Route::resource('books', BookController::class);

// Routes untuk Members
Route::resource('members', MemberController::class);

// Routes untuk Borrowings
Route::resource('borrowings', BorrowingController::class);
Route::post('borrowings/{borrowing}/return', [BorrowingController::class, 'return'])->name('borrowings.return');

// Routes untuk Borrowing Details
Route::post('borrowings/{borrowing}/details', [BorrowingDetailController::class, 'store'])->name('borrowing-details.store');
Route::put('borrowing-details/{detail}', [BorrowingDetailController::class, 'update'])->name('borrowing-details.update');
Route::delete('borrowing-details/{detail}', [BorrowingDetailController::class, 'destroy'])->name('borrowing-details.destroy');