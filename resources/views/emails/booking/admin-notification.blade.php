<x-mail::message>
# 📢 New Booking Notification

A new booking has just been created.

**User:** {{ $booking->user->name }}  
**Email:** {{ $booking->user->email }}  
**Activity:** {{ $booking->activity->name }}  
**Location:** {{ $booking->activity->location }}  
**Slots Booked:** {{ $booking->slots_booked }}  
**Date:** {{ $booking->activity->start_date->format('Y-m-d H:i') }}

<x-mail::button :url="config('app.url')">
View in Admin Panel
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
