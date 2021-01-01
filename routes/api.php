<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('login', 'Api\v1\auth\login@index');
Route::post('register', 'Api\v1\auth\register@index');
Route::post('password/email', 'Api\v1\auth\password@email');
Route::post('password/reset/{token}', 'Api\v1\auth\passwordReset@reset');
Route::prefix('investor')->middleware('investorAuth')->namespace('Api\v1\investor')->group(function () {
    Route::get('home', function () {
        return auth()->user();
    });
    Route::prefix('request')->group(function () {
        Route::post('depositRequest', 'DepositRequest@request');
        Route::post('transfer', 'transfer@request');
        Route::post('withdrawal', 'withdrawal@request');
        Route::post('rerunprofit', 'rerunprofit@request');
    });
    Route::prefix('old/request')->group(function () {
        Route::get('depositRequest', 'DepositRequest@allRequest');
        Route::get('depositRequest/{id}', 'DepositRequest@     ');
        Route::get('transfer', 'transfer@allRequest');
        Route::get('transfer/{id}', 'transfer@ShowRequest');
        Route::get('withdrawal', 'withdrawal@allRequest');
        Route::get('withdrawal/{id}', 'withdrawal@ShowRequest');
        Route::get('rerunprofit', 'rerunprofit@allRequest');
        Route::get('rerunprofit/{id}', 'rerunprofit@ShowRequest');
    });
});

Route::prefix('delivery')->middleware('delivery')->namespace('Api\v1\delivery')->group(function () {
    Route::post('getTransaction', 'home@getTransaction');
    Route::post('acceptTransaction/{id}', 'home@acceptTransaction');
});
Route::prefix('admin')->namespace('Api\v1\admin')->group(function () {
//Route::prefix('admin')->middleware('adminAuth')->namespace('Api\v1\admin')->group(function () {
    Route::get('home', function () {
        return auth()->user();
    });
    Route::prefix('profit')->group(function () {
        Route::post('calculateProfit', 'profit@CalculateProfit');
        Route::post('registerProfitInBalance/{id}', 'profit@registerProfitInBalance');
    });
    Route::prefix('investorStatus')->group(function () {
        Route::post('reject/{id}','investor@destroy');
        Route::post('accept/{id}','investor@accept');
    });
    Route::prefix('investorRequest')->group(function () {
        Route::prefix('deposit')->group(function () {
            Route::post('accept/{id}', 'Deposit@acceptInvestorRequest');
            Route::post('end/{id}', 'Deposit@endInvestorRequest');
            Route::post('reject/{id}', 'Deposit@rejectInvestorRequest');
        });
        Route::prefix('transfer')->group(function () {
            Route::post('reject/{id}', 'transfer@rejectTransfer');
            Route::post('accept/{id}', 'transfer@acceptTransfer');
        });
        Route::prefix('withdrawal')->group(function () {
            Route::post('reject/{id}', 'withdrawals@rejectWithdrawalRequest');
            Route::post('accept/{id}', 'withdrawals@acceptWithdrawalRequest');
            Route::post('end/{id}', 'withdrawals@EndWithdrawalRequest');
        });
        Route::prefix('rerunprofit')->group(function () {
            Route::post('reject/{id}', 'rerunprofit@reject');
            Route::post('accept/{id}', 'rerunprofit@acceptRequest');
        });
        Route::prefix('password')->group(function () {
            Route::post('change/investor', 'password@investor');
        });
    });
    Route::resources([
        'admin' => 'admin',
        'investor' => 'investor',
        'balance' => 'balance',
        'deposit' => 'Deposit',
        'withdrawals' => 'withdrawals',
        'transfers' => 'transfer',
        'rerunprofit' => 'reRunProfit',
    ]);
});
