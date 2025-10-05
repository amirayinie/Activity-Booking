<?php

namespace App\Services;

use App\Events\BookingCreated;
use App\Exceptions\InvalidActivityException;
use App\Exceptions\NotEnoughSlotsException;
use App\Models\Activity;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BookingService
{

    public function cancelBooking(Activity $activity, int $userId, ?string $reason)
    {
        $booking = Booking::where('activity_id', $activity->id)
            ->where('user_id', $userId)
            ->first();

        if (!in_array($booking->status, ['confirmed'])) {
            throw ValidationException::withMessages([
                'status' => 'only confirmed requests can be cancelled'
            ]);
        }

        if ($booking->Activity->start_date <= Carbon::now()) {
            throw ValidationException::withMessages([
                'status' => 'you can not cancel booking after the activity is started'
            ]);
        }

        $booking->update([
            'stauts' => 'cancelled',
            'cancel_reason' => $reason,
            'cancelled_at' => now()
        ]);

        $booking->Activity->increment('available_slots', $booking->slots_booked);
        // event

        return $booking;
    }

    public function createBooking(Activity $activity, array $request): Booking
    {
        return DB::transaction(function () use ($activity, $request) {
            if ($activity->available_slots < $request['slots_number']) {
                throw new NotEnoughSlotsException();
            }

            $activity->decrement('available_slots', $request['slots_number']);

            $booking = Booking::create([
                'activity_id' => $activity->id,
                'user_id' => Auth::id() ?? 1,
                'slots_booked' => $request['slots_number'],
                'status' => 'pending'
            ]);
            event(new BookingCreated($booking));

            return $booking;
        });
    }

    public function activityValidation($activityName): Activity
    {
        if (!$activity = Activity::where('name', $activityName)->first()) {
            throw new InvalidActivityException();
        };
        return $activity;
    }
}
