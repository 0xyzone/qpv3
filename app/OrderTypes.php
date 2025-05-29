<?php

namespace App;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

enum OrderTypes: string implements HasLabel, HasColor, HasIcon
{
    case TAKEAWAY = 'takeaway';
    case DINE_IN = 'dine_in';
    case DELIVERY = 'delivery';

    public function getLabel(): string
    {
        return match ($this) {
            self::TAKEAWAY => 'Takeaway',
            self::DINE_IN => 'Dine In',
            self::DELIVERY => 'Delivery',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::TAKEAWAY => 'info',
            self::DINE_IN => 'success',
            self::DELIVERY => 'warning',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::TAKEAWAY => 'heroicon-o-shopping-bag',
            self::DINE_IN => 'heroicon-o-table-cells',
            self::DELIVERY => 'heroicon-o-truck',
        };
    }
}