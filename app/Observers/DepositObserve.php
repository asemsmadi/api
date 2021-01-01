<?php

namespace App\Observers;

use App\Deposit;
use App\User;
use Illuminate\Support\Facades\Notification;

class DepositObserve
{
    /**
     * Handle the deposit "created" event.
     *
     * @param \App\Deposit $deposit
     * @return void
     */
    public function created(Deposit $deposit)
    {
        $admin = User::where('type', 1)->get();
        Notification::send($admin, new \App\Notifications\admin\Deposit\newRequestDeposit());
        $user = $deposit->user->user;
        $user->notify(new \App\Notifications\investor\Deposit\ReceiveYourDepositRequest());
    }

    /**
     * Handle the deposit "updated" event.
     *
     * @param \App\Deposit $deposit
     * @return void
     */
    public function updated(Deposit $deposit)
    {
        if ($deposit->status == 2) {
            $user = $deposit->user->user;
            $user->notify(new \App\Notifications\investor\Deposit\AcceptYourDepositRequest());
        }
        if ($deposit->status == 3) {
            $user = $deposit->user->user;
            $user->notify(new \App\Notifications\investor\Deposit\EndYourDepositRequest());
        }
        if ($deposit->status == 4) {
            $user = $deposit->user->user;
            $user->notify(new \App\Notifications\investor\Deposit\RejectYourDepositRequest());
        }
    }

    /**
     * Handle the deposit "deleted" event.
     *
     * @param \App\Deposit $deposit
     * @return void
     */
    public function deleted(Deposit $deposit)
    {
        //
    }

    /**
     * Handle the deposit "restored" event.
     *
     * @param \App\Deposit $deposit
     * @return void
     */
    public function restored(Deposit $deposit)
    {
        //
    }

    /**
     * Handle the deposit "force deleted" event.
     *
     * @param \App\Deposit $deposit
     * @return void
     */
    public function forceDeleted(Deposit $deposit)
    {
        //
    }
}
