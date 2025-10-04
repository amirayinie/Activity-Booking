<?php

namespace App\Services;

use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class MailService {
    public function send(Mailable $mailable , string $to) :void
    {
        try {
            Mail::to($to)->queue($mailable);
        }
        catch(Throwable $e){
            Log::error('failed to send email:' . $e->getMessage());
        }
    }
}