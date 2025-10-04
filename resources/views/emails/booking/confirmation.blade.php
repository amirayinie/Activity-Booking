<x-mail::message>
your booking is confirmed! 🎉

Hi {{$booking->user->name}} ,
your Booking for **{{$booking->Activity->name}}** has been successfully confirmed.

**Date:** {{ $booking->activity->start_date->format('Y-m-d H:i') }}  
**Location:** {{ $booking->activity->location }}  
**Slots Booked:** {{ $booking->slots_booked }}

<x-mail::button :url="config('app.url')">
view your booking
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
