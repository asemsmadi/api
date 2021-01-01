<?php

namespace App\Observers;

use App\admin;

class adminObserve
{
    /**
     * Handle the admin "created" event.
     *
     * @param  \App\admin  $admin
     * @return void
     */
    public function created(admin $admin)
    {
        //
    }

    /**
     * Handle the admin "updated" event.
     *
     * @param  \App\admin  $admin
     * @return void
     */
    public function updated(admin $admin)
    {
        //
    }

    /**
     * Handle the admin "deleted" event.
     *
     * @param  \App\admin  $admin
     * @return void
     */
    public function deleted(admin $admin)
    {
        //
    }

    /**
     * Handle the admin "restored" event.
     *
     * @param  \App\admin  $admin
     * @return void
     */
    public function restored(admin $admin)
    {
        //
    }

    /**
     * Handle the admin "force deleted" event.
     *
     * @param  \App\admin  $admin
     * @return void
     */
    public function forceDeleted(admin $admin)
    {
        //
    }
}
