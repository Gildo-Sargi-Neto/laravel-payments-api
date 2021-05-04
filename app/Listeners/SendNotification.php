<?php

namespace App\Listeners;

use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotification implements ShouldQueue
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
    public function handle()
    {
        $client = new Client();
        $client->post('http://o4d9z.mocklab.io/notify');
    }
}
