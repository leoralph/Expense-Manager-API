<?php

namespace App\Listeners;

use App\Events\ExpenseCreated;
use App\Notifications\ExpenseCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendExpenseNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ExpenseCreated $event): void
    {
        $event->expense->user->notify(new ExpenseCreatedNotification($event->expense));
    }
}
