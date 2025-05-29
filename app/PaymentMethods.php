<?php

namespace App;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

enum PaymentMethods: string implements HasLabel, HasColor, HasIcon
{
    case CASH = 'cash';
    case COD = 'cod';
    case FONEPAY = 'fonepay';

    public function getLabel(): string
    {
        return match ($this) {
            self::CASH => 'Cash',
            self::COD => 'Cash on Delivery',
            self::FONEPAY => 'Fonepay',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::CASH => 'success',  // Green
            self::COD => 'warning',    // Amber
            self::FONEPAY => 'primary', // Blue
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::CASH => 'heroicon-o-banknotes',
            self::COD => 'heroicon-o-truck',
            self::FONEPAY => 'heroicon-o-device-phone-mobile',
        };
    }
}