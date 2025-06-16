<?php

namespace Modules\Expenses\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Expenses\Services\ExpenseService;
use Modules\Expenses\Http\Requests\ExpenseRequest;
use Modules\Expenses\Http\Resources\ExpenseResource;
use Modules\Expenses\Http\Resources\ExpenseCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Expenses
 *
 * APIs for managing expenses
 */
class ExpenseController extends Controller
{
    public function __construct(protected ExpenseService $service)
    {
    }

    /**
     * List Expenses
     *
     * Get a list of all expenses with optional filtering.
     *
     * @queryParam category string Filter expenses by category. Example: food
     * @queryParam start_date string Filter expenses by start date (Y-m-d). Example: 2024-01-01
     * @queryParam end_date string Filter expenses by end date (Y-m-d). Example: 2024-12-31
     *
     * @response {
     *  "data": [
     *    {
     *      "id": "550e8400-e29b-41d4-a716-446655440000",
     *      "title": "Grocery Shopping",
     *      "amount": "150.75",
     *      "category": "food",
     *      "expense_date": "2024-03-21",
     *      "notes": "Weekly groceries",
     *      "created_at": "2024-03-21 10:00:00",
     *      "updated_at": "2024-03-21 10:00:00"
     *    }
     *  ],
     *  "meta": {
     *    "total": 1,
     *    "total_amount": "150.75"
     *  }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $expenses = $this->service->filterExpenses(
            $request->category,
            $request->start_date,
            $request->end_date
        );

        return response()->json(new ExpenseCollection($expenses));
    }

    /**
     * Create Expense
     *
     * Create a new expense record.
     *
     * @bodyParam title string required The title of the expense. Example: Grocery Shopping
     * @bodyParam amount numeric required The amount of the expense. Example: 150.75
     * @bodyParam category string required The category of the expense. Example: food
     * @bodyParam expense_date date required The date of the expense. Example: 2024-03-21
     * @bodyParam notes string optional Additional notes about the expense. Example: Weekly groceries from Walmart
     *
     * @response 201 {
     *  "message": "Expense created successfully",
     *  "data": {
     *    "id": "550e8400-e29b-41d4-a716-446655440000",
     *    "title": "Grocery Shopping",
     *    "amount": "150.75",
     *    "category": "food",
     *    "expense_date": "2024-03-21",
     *    "notes": "Weekly groceries from Walmart",
     *    "created_at": "2024-03-21 10:00:00",
     *    "updated_at": "2024-03-21 10:00:00"
     *  }
     * }
     */
    public function store(ExpenseRequest $request): JsonResponse
    {
        $expense = $this->service->createExpense($request->validated());

        return response()->json([
          'message' => 'Expense created successfully',
          'data' => new ExpenseResource($expense)
        ], Response::HTTP_CREATED);
    }

    /**
     * Get Expense
     *
     * Get details of a specific expense.
     *
     * @urlParam id string required The UUID of the expense. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response {
     *  "message": "Expense fetched successfully",
     *  "data": {
     *    "id": "550e8400-e29b-41d4-a716-446655440000",
     *    "title": "Grocery Shopping",
     *    "amount": "150.75",
     *    "category": "food",
     *    "expense_date": "2024-03-21",
     *    "notes": "Weekly groceries from Walmart",
     *    "created_at": "2024-03-21 10:00:00",
     *    "updated_at": "2024-03-21 10:00:00"
     *  }
     * }
     *
     * @response 404 {
     *  "message": "Expense not found"
     * }
     */
    public function show(string $id): JsonResponse
    {
        $expense = $this->service->getExpense($id);

        if (!$expense) {
            return response()->json(['message' => 'Expense not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
          'message' => 'Expense fetched successfully',
          'data' => new ExpenseResource($expense)
        ]);
    }

    /**
     * Update Expense
     *
     * Update an existing expense record.
     *
     * @urlParam id string required The UUID of the expense. Example: 550e8400-e29b-41d4-a716-446655440000
     * @bodyParam title string required The title of the expense. Example: Grocery Shopping
     * @bodyParam amount numeric required The amount of the expense. Example: 150.75
     * @bodyParam category string required The category of the expense. Example: food
     * @bodyParam expense_date date required The date of the expense. Example: 2024-03-21
     * @bodyParam notes string optional Additional notes about the expense. Example: Weekly groceries from Walmart
     *
     * @response {
     *  "message": "Expense updated successfully",
     *  "data": {
     *    "id": "550e8400-e29b-41d4-a716-446655440000",
     *    "title": "Grocery Shopping",
     *    "amount": "150.75",
     *    "category": "food",
     *    "expense_date": "2024-03-21",
     *    "notes": "Weekly groceries from Walmart",
     *    "created_at": "2024-03-21 10:00:00",
     *    "updated_at": "2024-03-21 10:00:00"
     *  }
     * }
     *
     * @response 404 {
     *  "message": "Expense not found"
     * }
     */
    public function update(ExpenseRequest $request, string $id): JsonResponse
    {
        $expense = $this->service->getExpense($id);

        if (!$expense) {
            return response()->json(['message' => 'Expense not found'], Response::HTTP_NOT_FOUND);
        }

        $this->service->updateExpense($id, $request->validated());
        
        return response()->json([
          'message' => 'Expense updated successfully',
          'data' => new ExpenseResource($expense->fresh())
        ]);
    }

    /**
     * Delete Expense
     *
     * Delete an existing expense record.
     *
     * @urlParam id string required The UUID of the expense. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @response {
     *  "message": "Expense deleted successfully",
     *  "data": {
     *    "id": "550e8400-e29b-41d4-a716-446655440000",
     *    "title": "Grocery Shopping",
     *    "amount": "150.75",
     *    "category": "food",
     *    "expense_date": "2024-03-21",
     *    "notes": "Weekly groceries from Walmart",
     *    "created_at": "2024-03-21 10:00:00",
     *    "updated_at": "2024-03-21 10:00:00"
     *  }
     * }
     *
     * @response 404 {
     *  "message": "Expense not found"
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        $expense = $this->service->getExpense($id);

        if (!$expense) {
            return response()->json(['message' => 'Expense not found'], Response::HTTP_NOT_FOUND);
        }

        $this->service->deleteExpense($id);

        return response()->json([
          'message' => 'Expense deleted successfully',
          'data' => new ExpenseResource($expense)
        ]);
    }
} 