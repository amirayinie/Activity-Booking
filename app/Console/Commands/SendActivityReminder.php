<?php

namespace App\Console\Commands;

use App\Services\ReminderService;
use Illuminate\Console\Command;

class SendActivityReminder extends Command
{
    protected $signature = 'send:activity-reminder';
    protected $description = 'Command description';

    public function __construct(private ReminderService $reminderService)
    {
        parent::__construct();
    }


    public function handle() :int
    {
       $count = $this->reminderService->sendUpcomingReminders();
       $this->info("✅ {$count} reminder(s) queued at " . now());
       return self::SUCCESS;
    }
}
