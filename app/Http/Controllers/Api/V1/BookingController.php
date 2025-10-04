<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
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
    public function __invoke(BookingRequest $request)
    {
        $validated = $request->validated();
        try {
            $activity = Activity::where('name', $validated['activity_name'])->firstOrFail();
        } catch (Exception $e) {
            return json(['error' => 'there is no activity with given name'], 'not found', '404');
        }

        $booking = $this->bookingService->createBooking($activity, $validated);

        return json(
            [
                'status' => $booking->status,
            ],
            'ok',
            201
        );
    }
}
