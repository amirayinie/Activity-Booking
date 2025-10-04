<?php

namespace App\Listeners;

use App\Models\Booking;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Queue\InteractsWithQueue;

class MarkReminderAsSent
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
        $headers = $event->message->getHeaders();
        $bookingIdHeader = $headers->get('X-Booking-Reminder');

        if ($bookingIdHeader) {
            $bookingId = (int) $bookingIdHeader->getBody();
            Booking::whereKey($bookingId)
                ->whereNotNull('reminder_queued_at')
                ->whereNull('reminder_sent_at')
                ->update(['reminder_sent_at' => now()]);
        }

    }
}
