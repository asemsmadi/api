<?php

namespace App\Observers;

use App\balance;

class balanceObserve
{
    /**
     * Handle the balance "created" event.
     *
     * @param \App\balance $balance
     * @return void
     */
    public function created(balance $balance)
    {
        $user = $balance->user->user;
        $user->notify(new \App\Notifications\investor\balance\addbalance());
    }

    /**
     * Handle the balance "updated" event.
     *
     * @param \App\balance $balance
     * @return void
     */
    public function updated(balance $balance)
    {
        if ($balance->status == 6) {
            $user = $balance->user->user;
            $user->notify(new \App\Notifications\investor\balance\Removebalance());

        }
    }

    /**
     * Handle the balance "deleted" event.
     *
     * @param \App\balance $balance
     * @return void
     */
    public function deleted(balance $balance)
    {

    }

    /**
     * Handle the balance "restored" event.
     *
     * @param \App\balance $balance
     * @return void
     */
    public function restored(balance $balance)
    {
        //
    }

    /**
     * Handle the balance "force deleted" event.
     *
     * @param \App\balance $balance
     * @return void
     */
    public function forceDeleted(balance $balance)
    {
        //
    }
}
