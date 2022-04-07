<?php

namespace App\Listeners;
use Illuminate\Support\Facades\Artisan;

class MakeModifiedScheduleSnapshot
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Artisan::call('schedule:snapshot');
    }
}
