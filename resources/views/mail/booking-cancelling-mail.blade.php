<x-mail::message>
# Booking Cancelled

Hello {{ $booking->user->name }},

Your booking for **{{ $booking->activity->name }}** on **{{ $booking->activity->start_date->format('d M Y H:i') }}** has been cancelled.

@if($booking->cancel_reason)
Reason: "{{ $booking->cancel_reason }}"
@endif

We hope to see you in another activity soon!

Thanks,  
{{ config('app.name') }}
</x-mail::message>
