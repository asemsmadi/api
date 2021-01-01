<?php

namespace App\Observers;

use App\Investor;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class InvestorObserve
{
    /**
     * Handle the investor "created" event.
     *
     * @param \App\Investor $investor
     * @return void
     */
    public function created(Investor $investor)
    {
        $user = $investor->user;
        $user->notify(new \App\Notifications\Investor\createInvestor());
        $admin = \App\User::whereIn('type', [1, 2])->get();
        Notification::send($admin, new \App\Notifications\admin\createInvestor());
    }

    /**
     * Handle the investor "updated" event.
     *
     * @param \App\Investor $investor
     * @return void
     */
    public function updated(Investor $investor)
    {
        if ($investor->accept == 'yes') {
            $investor->user->notify(new \App\Notifications\Investor\update());
        }
    }

    /**
     * Handle the investor "deleted" event.
     *
     * @param \App\Investor $investor
     * @return void
     */
    public function deleted(Investor $investor)
    {
        if (Storage::exists($investor->sponsorCardImage)) {
            Storage::delete($investor->sponsorCardImage);
        }
        if (Storage::exists($investor->UserImage)) {
            Storage::delete($investor->UserImage);
        }
        if (Storage::exists($investor->PassPortImage)) {
            Storage::delete($investor->PassPortImage);
        }
        if (Storage::exists($investor->UserCardImage)) {
            Storage::delete($investor->UserCardImage);
        }
    }

    /**
     * Handle the investor "restored" event.
     *
     * @param \App\Investor $investor
     * @return void
     */
    public function restored(Investor $investor)
    {
        //
    }

    /**
     * Handle the investor "force deleted" event.
     *
     * @param \App\Investor $investor
     * @return void
     */
    public function forceDeleted(Investor $investor)
    {
        //
    }
}
