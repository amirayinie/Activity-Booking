<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use function App\Utilities\json;

class NotEnoughSlotsException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     */
    public function render(): JsonResponse
    {
        return json(['error' => 'Sorry, there are not enough available slots for this activity'], 'fail', 422);
    }
}
