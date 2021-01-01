<?php

namespace App\Observers;

use App\User;
use App\withdrawal;
use Illuminate\Support\Facades\Notification;

class ObserveWithdrawal
{
    /**
     * Handle the withdrawal "created" event.
     *
     * @param \App\withdrawal $withdrawal
     * @return void
     */
    public function created(withdrawal $withdrawal)
    {
        $user = $withdrawal->investor->user->notify(new \App\Notifications\Investor\withdrawal\ReceiveYourWithdrawal());
        $admin = User::where('type', 1)->get();
        Notification::send($admin, new \App\Notifications\admin\withdrawal\NewWithdrawalRequest());

    }

    /**
     * Handle the withdrawal "updated" event.
     *
     * @param \App\withdrawal $withdrawal
     * @return void
     */
    public function updated(withdrawal $withdrawal)
    {
        if ($withdrawal->status == 4) {
            $user = $withdrawal->investor->user->notify(new \App\Notifications\Investor\withdrawal\RejectYourWithdrawal());
        } else if ($withdrawal->status == 2) {
            $user = $withdrawal->investor->user->notify(new \App\Notifications\Investor\withdrawal\AcceptYourWithdrawal($withdrawal->code));
        } else if ($withdrawal->status == 3) {
            $user = $withdrawal->investor->user->notify(new \App\Notifications\Investor\withdrawal\CompleateYourWithdrawal());
        }
    }

    /**
     * Handle the withdrawal "deleted" event.
     *
     * @param \App\withdrawal $withdrawal
     * @return void
     */
    public function deleted(withdrawal $withdrawal)
    {
        //
    }

    /**
     * Handle the withdrawal "restored" event.
     *
     * @param \App\withdrawal $withdrawal
     * @return void
     */
    public function restored(withdrawal $withdrawal)
    {
        //
    }

    /**
     * Handle the withdrawal "force deleted" event.
     *
     * @param \App\withdrawal $withdrawal
     * @return void
     */
    public function forceDeleted(withdrawal $withdrawal)
    {
        //
    }
}
