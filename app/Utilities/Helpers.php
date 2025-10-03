<?php

namespace App\Utilities;

    function json($data = [], $message = 'ok', $httpStatus = 200): \Illuminate\Http\JsonResponse
    {
        $response = [
            'status' => (int) ($httpStatus / 100) === 2 ? 'success' : 'fail',
            'meta' => [
                'message' => $message,
            ],
            'data' => $data ?? [],
        ];

        return response()->json($response, $httpStatus);
    }