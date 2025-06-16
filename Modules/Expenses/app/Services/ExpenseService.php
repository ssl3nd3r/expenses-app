<?php

namespace Modules\Expenses\Services;

use Modules\Expenses\Repositories\ExpenseRepository;
use Modules\Expenses\Models\Expense;
use Modules\Expenses\Events\ExpenseCreated;
use Illuminate\Database\Eloquent\Collection;

class ExpenseService
{
    public function __construct(protected ExpenseRepository $repository)
    {
    }

    public function getAllExpenses(): Collection
    {
        return $this->repository->all();
    }

    public function getExpense(string $id): ?Expense
    {
        return $this->repository->find($id);
    }

    public function createExpense(array $data): Expense
    {
        $expense = $this->repository->create($data);
        
        event(new ExpenseCreated($expense));
        
        return $expense;
    }

    public function updateExpense(string $id, array $data): bool
    {
        return $this->repository->update($id, $data);
    }

    public function deleteExpense(string $id): bool
    {
        return $this->repository->delete($id);
    }

    public function filterExpenses(?string $category, ?string $startDate, ?string $endDate): Collection
    {
        return $this->repository->filterByCategoryAndDateRange($category, $startDate, $endDate);
    }
} 