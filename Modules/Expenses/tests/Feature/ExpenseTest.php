<?php

namespace Modules\Expenses\Tests\Feature;

use Tests\TestCase;
use Modules\Expenses\Models\Expense;
use Modules\Expenses\Enums\ExpenseCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExpenseTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_expense(): void
    {
        $expenseData = [
            'title' => 'Test Expense',
            'amount' => 100.50,
            'category' => ExpenseCategory::FOOD->value,
            'expense_date' => '2024-03-21',
            'notes' => 'Test notes',
        ];

        $response = $this->postJson('/api/expenses', $expenseData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'amount',
                    'category',
                    'expense_date',
                    'notes',
                    'created_at',
                    'updated_at',
                ],
            ]);

        $this->assertDatabaseHas('expenses', [
            'title' => $expenseData['title'],
            'amount' => $expenseData['amount'],
            'category' => $expenseData['category'],
        ]);
    }

    public function test_can_list_expenses(): void
    {
        Expense::factory()->count(3)->create();

        $response = $this->getJson('/api/expenses');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'amount',
                        'category',
                        'expense_date',
                        'notes',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'meta' => [
                    'total',
                    'total_amount',
                ],
            ]);
    }

    public function test_can_filter_expenses_by_category(): void
    {
        Expense::factory()->create(['category' => ExpenseCategory::FOOD->value]);
        Expense::factory()->create(['category' => ExpenseCategory::TRANSPORT->value]);

        $response = $this->getJson('/api/expenses?category=' . ExpenseCategory::FOOD->value);

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.category', ExpenseCategory::FOOD->value);
    }
} 