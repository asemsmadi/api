<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

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
    abort(500);
});

Route::get('/test', function () {
    $investor = \App\Investor::findOrFail(7);
    $investorBalance = $investor->investorBalance;
    $balance = ((float)$investorBalance->profit - (float)$investorBalance->pending);
    return 136 <= $balance;
});

