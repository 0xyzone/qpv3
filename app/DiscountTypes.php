<?php

namespace App;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

enum DiscountTypes: string implements HasLabel, HasColor, HasIcon
{
    case PERCENTAGE = 'percentage';
    case FIXED_AMOUNT = 'fixed_amount';

    public function getLabel(): string
    {
        return match ($this) {
            self::PERCENTAGE => 'Percentage Off',
            self::FIXED_AMOUNT => 'Fixed Amount Off',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::PERCENTAGE => 'success',  // Green
            self::FIXED_AMOUNT => 'primary', // Blue
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::PERCENTAGE => 'heroicon-o-receipt-percent',
            self::FIXED_AMOUNT => 'heroicon-o-currency-dollar',
        };
    }
}