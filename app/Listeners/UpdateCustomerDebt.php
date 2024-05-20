<?php

namespace App\Listeners;

use App\Enums\OrderStatus;
use App\Events\OrderStatusUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UpdateCustomerDebt
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderStatusUpdated $event)
    {
        if ($event->order->status === OrderStatus::Delivered && is_null($event->order->delivered_at)) {
            $event->order->delivered_at = now();
            $event->order->customer->increment('debt', $event->order->total_price);
            $event->order->save();
        }
    }
}
