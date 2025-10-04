<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Mail\BookingConfirmationMail;
use App\Services\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendBookingConfirmationEmail
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
    public function handle(BookingCreated $event): void
    {
        $booking = $event->booking;
        $this->mailService->send(new BookingConfirmationMail($booking),$booking->user->email);

    }
}
