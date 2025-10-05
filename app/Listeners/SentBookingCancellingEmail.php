<?php

namespace App\Listeners;

use App\Events\BookingCancelled;
use App\Mail\BookingCancellingMail;
use App\Services\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SentBookingCancellingEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(public MailService $mailService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BookingCancelled $event): void
    {
        $booking = $event->booking;
        $this->mailService->send(new BookingCancellingMail($booking),$booking->user->email);
    }
}
