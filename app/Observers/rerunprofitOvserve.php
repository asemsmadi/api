<?php

namespace App\Observers;

use App\rerunprofit;
use App\User;
use Illuminate\Support\Facades\Notification;

class rerunprofitOvserve
{
    /**
     * Handle the rerunprofit "created" event.
     *
     * @param \App\rerunprofit $rerunprofit
     * @return void
     */
    public function created(rerunprofit $rerunprofit)
    {
        $rerunprofit->investor->user->notify(new \App\Notifications\Investor\rerunprofit\rerunprofitRequest());
        $admin = User::where('type', 1)->get();
        Notification::send($admin, new \App\Notifications\admin\rerunprofit\rerunprofitRequest());
    }

    /**
     * Handle the rerunprofit "updated" event.
     *
     * @param \App\rerunprofit $rerunprofit
     * @return void
     */
    public function updated(rerunprofit $rerunprofit)
    {
        if ($rerunprofit->status == 4) {
            $rerunprofit->investor->user->notify(new \App\Notifications\Investor\rerunprofit\RejectrerunprofitRequest());
        }
        if ($rerunprofit->status == 2) {
            $rerunprofit->investor->user->notify(new \App\Notifications\Investor\rerunprofit\AcepptrerunprofitRequest());
        }
    }

    /**
     * Handle the rerunprofit "deleted" event.
     *
     * @param \App\rerunprofit $rerunprofit
     * @return void
     */
    public function deleted(rerunprofit $rerunprofit)
    {
        //
    }

    /**
     * Handle the rerunprofit "restored" event.
     *
     * @param \App\rerunprofit $rerunprofit
     * @return void
     */
    public function restored(rerunprofit $rerunprofit)
    {
        //
    }

    /**
     * Handle the rerunprofit "force deleted" event.
     *
     * @param \App\rerunprofit $rerunprofit
     * @return void
     */
    public function forceDeleted(rerunprofit $rerunprofit)
    {
        //
    }
}
