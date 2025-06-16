<?php

namespace Modules\Expenses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Expenses\Enums\ExpenseCategory;

class ExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'category' => ['required', 'string', 'in:' . implode(',', ExpenseCategory::values())],
            'expense_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ];
    }
} 