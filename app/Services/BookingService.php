<?php

namespace App\Services;

use App\Events\BookingCreated;
use App\Exceptions\NotEnoughSlotsException;
use App\Models\Activity;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingService
{

    public function createBooking(Activity $activity, array $request)
    {
        return DB::transaction(function () use ($activity, $request) {
            if ($activity->available_slots < $request['slots_number']) {
                throw new NotEnoughSlotsException();
            }

            $activity->decrement('available_slots', $request['slots_number']);

            $booking = Booking::create([
                'activity_id' => $activity->id,
                'user_id' => Auth::id()?? 1,
                'slots_booked' => $request['slots_number'],
                'status' => 'pending'
            ]);
            event(new BookingCreated($booking));

            return $booking;
        });
    }
}
