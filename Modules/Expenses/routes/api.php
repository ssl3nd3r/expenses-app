<?php

use Illuminate\Support\Facades\Route;
use Modules\Expenses\Http\Controllers\ExpenseController;

Route::prefix('expenses')->group(function () {
    Route::get('/', [ExpenseController::class, 'index']);
    Route::post('/', [ExpenseController::class, 'store']);
    Route::get('/{id}', [ExpenseController::class, 'show']);
    Route::put('/{id}', [ExpenseController::class, 'update']);
    Route::delete('/{id}', [ExpenseController::class, 'destroy']);
});
