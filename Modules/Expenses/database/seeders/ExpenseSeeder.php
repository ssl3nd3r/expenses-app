<?php

namespace Modules\Expenses\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Expenses\Models\Expense;

class ExpenseSeeder extends Seeder
{
    public function run(): void
    {
        Expense::factory()->count(80)->create();
    }
} 