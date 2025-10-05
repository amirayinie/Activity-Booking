<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

use function App\Utilities\json;

class InvalidActivityException extends Exception
{
     public function render(): JsonResponse
    {
        return json(['error' => 'there is no activity with given name'], 'not found', 404);;
    }
}
