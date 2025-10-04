<?php

namespace App\Utilities;

use Illuminate\Http\Request;
use Illuminate\support\Str;
use Illuminate\Support\Facades\Storage;


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

function imageSaver($image, string  $baseName): string
{
    $fileName = Str::slug($baseName) . '-' . time() . '.png';
    $path = $image->storeAs('activities', $fileName, 'public');
    return $path;
}

function deleteImage($image): void
{
        Storage::disk('public')->delete($image);
    
}
