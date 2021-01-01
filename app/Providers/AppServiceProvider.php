<?php

namespace App\Providers;

use App\Http\Controllers\Api\v1\admin\admin;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \App\admin::observe(\App\Observers\adminObserve::class);
        \App\Investor::observe(\App\Observers\InvestorObserve::class);
        \App\balance::observe(\App\Observers\balanceObserve::class);
        \App\Deposit::observe(\App\Observers\DepositObserve::class);
        \App\transfer::observe(\App\Observers\transferObserve::class);
        \App\withdrawal::observe(\App\Observers\ObserveWithdrawal::class);
        \App\rerunprofit::observe(\App\Observers\rerunprofitOvserve::class);
    }
}
