<?php

namespace Modules\Expenses\Repositories;

use Modules\Expenses\Models\Expense;
use Illuminate\Database\Eloquent\Collection;

class ExpenseRepository
{
    public function __construct(protected Expense $model)
    {
    }

    public function all(): Collection
    {
        return $this->model->latest()->get();
    }

    public function find(string $id): ?Expense
    {
        return $this->model->find($id);
    }

    public function create(array $data): Expense
    {
        return $this->model->create($data);
    }

    public function update(string $id, array $data): bool
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function delete(string $id): bool
    {
        return $this->model->where('id', $id)->delete();
    }

    public function filterByCategoryAndDateRange(?string $category, ?string $startDate, ?string $endDate): Collection
    {
        $query = $this->model->query();

        if ($category) {
            $query->where('category', $category);
        }

        if ($startDate) {
            $query->where('expense_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('expense_date', '<=', $endDate);
        }

        return $query->latest()->get();
    }
} 