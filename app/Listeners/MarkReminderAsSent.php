<?php

namespace App\Listeners;

use App\Models\Booking;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Log;

class MarkReminderAsSent implements ShouldQueue
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
         Log::info('MessageSent listener triggered!', [
        'headers' => $event->message->getHeaders()->toString(),
    ]);
        $headers = $event->message->getHeaders();
        $bookingIdHeader = $headers->get('X-booking-reminder');

        if ($bookingIdHeader) {
            $bookingId = (int) $bookingIdHeader->getBody();
            Booking::whereKey($bookingId)
                ->whereNotNull('reminder_queued_at')
                ->whereNull('reminder_sent_at')
                ->update(['reminder_sent_at' => now()]);
        }

    }
}
