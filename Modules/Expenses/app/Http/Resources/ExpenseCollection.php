<?php

namespace Modules\Expenses\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ExpenseCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => $this->collection,
            'meta' => [
                'total' => $this->collection->count(),
                'total_amount' => $this->collection->sum('amount'),
            ],
        ];
    }
} 