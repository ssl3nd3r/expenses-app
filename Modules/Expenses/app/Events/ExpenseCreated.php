<?php

namespace Modules\Expenses\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Expenses\Models\Expense;

class ExpenseCreated
{
    use SerializesModels;

    public function __construct(public Expense $expense)
    {
    }
} 