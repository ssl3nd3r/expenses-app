<?php

namespace Modules\Expenses\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Expenses\Models\Expense;

class NewExpenseNotification extends Notification
{
    use Queueable;

    public function __construct(protected Expense $expense)
    {
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Expense Created')
            ->line('A new expense has been created.')
            ->line("Title: {$this->expense->title}")
            ->line("Amount: {$this->expense->amount}")
            ->line("Category: {$this->expense->category}")
            ->line("Date: {$this->expense->expense_date->format('Y-m-d')}")
            ->line("Notes: {$this->expense->notes}");
    }

    public function toArray($notifiable): array
    {
        return [
            'expense_id' => $this->expense->id,
            'title' => $this->expense->title,
            'amount' => $this->expense->amount,
            'category' => $this->expense->category,
            'expense_date' => $this->expense->expense_date->format('Y-m-d'),
        ];
    }
} 