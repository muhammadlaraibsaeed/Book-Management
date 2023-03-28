<?php

use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use NunoMaduro\Collision\Adapters\Phpunit\Style;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $books = Book::all();
    return view('welcome',compact('books'));
});

// for authentication of User either is author or not

Auth::routes();

// after login it will login that page
Route::get('/home', [HomeController::class, 'index'])->name('home');




Route::resource('books',BookController::class)->middleware('auth');

Route::get('addBook',[BookController::class,'form'])->name('addBook.form')->middleware('auth');
