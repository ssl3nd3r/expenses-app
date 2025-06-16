<?php

namespace Modules\Expenses\Listeners;

use Modules\Expenses\Events\ExpenseCreated;
use Modules\Expenses\Notifications\NewExpenseNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class SendExpenseCreatedNotification
{
    public function handle(ExpenseCreated $event): void
    {
        $user = Auth::user();
     
        if ($user) {
            Notification::send($user, new NewExpenseNotification($event->expense));
        }
        else {
            Notification::route('mail', 'jimmy_jra@hotmail.com')->notify(new NewExpenseNotification($event->expense));
        }
    }
} 