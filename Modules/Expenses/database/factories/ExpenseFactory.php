<?php

namespace Modules\Expenses\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Expenses\Models\Expense;
use Modules\Expenses\Enums\ExpenseCategory;

class ExpenseFactory extends Factory
{
    protected $model = Expense::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'category' => $this->faker->randomElement(ExpenseCategory::cases())->value,
            'expense_date' => $this->faker->date(),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
} 