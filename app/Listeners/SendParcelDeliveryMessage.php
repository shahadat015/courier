<?php

namespace App\Listeners;

use App\Traits\MimSms;
use App\Events\ParcelAssigned;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendParcelDeliveryMessage
{
    use MimSms;

    /**
     * Handle the event.
     *
     * @param  ParcelAssigned  $event
     * @return void
     */
    public function handle(ParcelAssigned $event)
    {
        $this->sendSms($event->messages);
    }
}
