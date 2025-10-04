<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Mail\AdminBookingNotificationMail;
use App\Services\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAdminOfBooking
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
        $adminEmail = config('mail.admin_address', 'admin@tourism-app.test');
        $this->mailService->send(new AdminBookingNotificationMail($booking) , $adminEmail);
    }
}
