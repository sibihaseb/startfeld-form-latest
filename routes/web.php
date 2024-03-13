<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\EmailVerifyController;

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

Route::get('{any}', function () {
    return view('welcome');
})->where('any', '.*');


//Email Verification Route
Route::get('email/verify/{id}/{hash}', [EmailVerifyController::class, '__invoke'])->name('verification.verify');
