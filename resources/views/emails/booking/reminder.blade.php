{{-- resources/views/emails/booking/reminder.blade.php --}}
<x-mail::message>
# ⏰ Friendly Reminder

Hi {{ $booking->user->name }},

Your activity **{{ $booking->activity->name }}** starts in **24 hours**.

**Date:** {{ $booking->activity->start_date->format('Y-m-d H:i') }}  
**Location:** {{ $booking->activity->location }}  
**Slots:** {{ $booking->slots_booked }}

<x-mail::button :url="config('app.url')">
View Details
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
