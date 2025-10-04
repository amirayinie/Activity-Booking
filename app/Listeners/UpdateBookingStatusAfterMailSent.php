<?php

namespace App\Listeners;

use App\Models\Booking;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Queue\InteractsWithQueue;

class UpdateBookingStatusAfterMailSent
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
    public function handle(MessageSent $event): void
    {
         $booking = $event->data['booking'] ?? null;

         if ($booking instanceof Booking){
            $booking->update(['status' => 'confirmed']);
         }
    }
}
