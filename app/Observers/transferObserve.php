<?php

namespace App\Observers;

use App\transfer;
use App\User;

class transferObserve
{
    /**
     * Handle the transfer "created" event.
     *
     * @param \App\transfer $transfer
     * @return void
     */
    public function created(transfer $transfer)
    {
        $investor = $transfer->from;
        $investor->user->notify(new \App\Notifications\investor\transfer\transferRequest());
        $admin = User::where('type', 1)->get();
        \Notification::send($admin, new \App\Notifications\admin\transfer\transferRequest());
    }

    /**
     * Handle the transfer "updated" event.
     *
     * @param \App\transfer $transfer
     * @return void
     */
    public function updated(transfer $transfer)
    {
        if ($transfer->status == 4) {
            $investor = $transfer->from;
            $investor->user->notify(new \App\Notifications\investor\transfer\transferReject());
        }
        if ($transfer->status == 2) {
            $investorFrom = $transfer->from;
            $investorFrom->user->notify(new \App\Notifications\investor\transfer\transferAccept());
            $investorTo = $transfer->to;
            $investorTo->user->notify(new \App\Notifications\investor\transfer\Newtransfer());
        }

    }

    /**
     * Handle the transfer "deleted" event.
     *
     * @param \App\transfer $transfer
     * @return void
     */
    public function deleted(transfer $transfer)
    {
        //
    }

    /**
     * Handle the transfer "restored" event.
     *
     * @param \App\transfer $transfer
     * @return void
     */
    public function restored(transfer $transfer)
    {
        //
    }

    /**
     * Handle the transfer "force deleted" event.
     *
     * @param \App\transfer $transfer
     * @return void
     */
    public function forceDeleted(transfer $transfer)
    {
        //
    }
}
