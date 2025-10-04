<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'            => $this->name,
            'description'     => $this->description,
            'image_url'       =>$this->image ? asset('storage/' . $this->image) : null,
            'location'        => $this->location,
            'price'           => $this->price,
            'available_slots' => $this->available_slots,
            'start_date'      => $this->start_date->toDateString()
        ];
    }
}
