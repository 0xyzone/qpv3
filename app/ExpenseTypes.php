<?php

namespace App;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

enum ExpenseTypes: string implements HasLabel, HasColor, HasIcon
{
    case SALARY = 'salary';
    case WAGES = 'wages';
    case SHOP_RESOURCE = 'shop_resource';
    case GROCERIES = 'groceries';
    case FURNITURE = 'furniture';
    case UTILITIES = 'utilities';
    case RENT = 'rent';
    case MISC = 'misc';

    public function getLabel(): string
    {
        return match ($this) {
            self::SALARY => 'Salary',
            self::WAGES => 'Wages',
            self::SHOP_RESOURCE => 'Shop Resource',
            self::GROCERIES => 'Groceries',
            self::FURNITURE => 'Furniture',
            self::UTILITIES => 'Utilities',
            self::RENT => 'Rent',
            self::MISC => 'Miscellaneous',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::SALARY => 'success',
            self::WAGES => 'info',
            self::SHOP_RESOURCE => 'primary',
            self::GROCERIES => 'warning',
            self::FURNITURE => 'violet',
            self::UTILITIES => 'blue',
            self::RENT => 'orange',
            self::MISC => 'gray',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::SALARY => 'heroicon-o-banknotes',
            self::WAGES => 'heroicon-o-currency-dollar',
            self::SHOP_RESOURCE => 'heroicon-o-shopping-bag',
            self::GROCERIES => 'heroicon-o-shopping-cart',
            self::FURNITURE => 'heroicon-o-table-cells',
            self::UTILITIES => 'heroicon-o-light-bulb',
            self::RENT => 'heroicon-o-home-modern',
            self::MISC => 'heroicon-o-document-text',
        };
    }
}