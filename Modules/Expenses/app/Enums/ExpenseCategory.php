<?php

namespace Modules\Expenses\Enums;

enum ExpenseCategory: string
{
    case FOOD = 'food';
    case TRANSPORT = 'transport';
    case HOUSING = 'housing';
    case UTILITIES = 'utilities';
    case ENTERTAINMENT = 'entertainment';
    case SHOPPING = 'shopping';
    case HEALTH = 'health';
    case EDUCATION = 'education';
    case TRAVEL = 'travel';
    case OTHER = 'other';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
} 