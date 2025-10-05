<?php

namespace App\Services;

use App\Mail\BookingReminderMail;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class ReminderService
{
    public function __construct(private MailService $mailService) {}


    public function sendUpcomingReminders(): int
    {
        $now = now();
        $from = $now->copy()->addDay()->startOfMinute();
        $to   = $now->copy()->addDay()->addMinutes(5)->endOfMinute();

        $count = 0;

        Booking::query()
            ->whereNull('reminder_queued_at')
            ->where('status', 'confirmed')
            ->whereHas('activity', function ($q) use ($from, $to) {
                $q->whereBetween('start_date', [$from, $to]);
            })
            ->with(['user', 'activity'])
            ->chunkById(100, function ($bookings) use (&$count) {
                foreach ($bookings as $booking) {
                    DB::transaction(function () use ($booking, &$count) {
                        $updated = Booking::whereKey($booking->id)
                            ->whereNull('reminder_queued_at')
                            ->update(['reminder_queued_at' => now()]);

                        if ($updated) {
                            $this->mailService->send(
                                new BookingReminderMail($booking),
                                $booking->user->email
                            );
                            $count++;
                        }
                    });
                }
            });

        return $count;
    }
}
