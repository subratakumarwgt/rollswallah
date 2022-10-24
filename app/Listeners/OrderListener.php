<?php

namespace App\Listeners;

use App\Events\NewOrder;
use App\Http\Controllers\NotifyController;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Event;

class OrderListener
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
    public function handle(NewOrder $newOrder)
    {  
        // if($newOrder->order->order_type == "website"){
            
        // }
        $notify = new NotifyController();
		$notify->sendOrderNotification($newOrder->order);
    }
}
