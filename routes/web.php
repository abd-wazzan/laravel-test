<?php

use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::prefix('users')->middleware('auth:web')
    ->controller(UserController::class)
    ->group(function () {
        Route::get('trashed', 'trashed')->name('users.trashed');
        Route::patch('{user}/restore', 'restore')->name('users.restore');
        Route::delete('{user}/delete', 'delete')->name('users.delete');
    });
Route::resource('users', UserController::class)
    ->middleware('auth:web');
