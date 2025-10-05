<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Requests\CancelBookingRequest;
use App\Models\Activity;
use App\Models\Booking;
use App\Services\BookingService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

use function App\Utilities\json;

class BookingController extends Controller
{
    public function __construct(protected BookingService $bookingService) {}

    public function createBooking(BookingRequest $request)
    {
        $validated = $request->validated();
        $activity = $this->bookingService->activityValidation($validated['activity_name']);

        $booking = $this->bookingService->createBooking($activity, $validated);

        return json(
            [
                'status' => $booking->status,
            ],
            'booking created',
            201
        );
    }

    public function cancelBooking(CancelBookingRequest $request)
    {
        $userId = Auth::id();
        $validated = $request->validated();

        $activity = $this->bookingService->activityValidation($validated['activity_name']);

        $cancelledBooking = $this->bookingService->cancelBooking($activity, $userId, $validated['reason']);

        return json(
            [
                'status' => $cancelledBooking->status,
            ],
            'booking cancelled',
            200
        );
    }
}
