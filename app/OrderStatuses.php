<?php

namespace App;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

enum OrderStatuses: string implements HasLabel, HasColor, HasIcon
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case PREPARING = 'preparing';
    case READY = 'ready';
    case DELIVERED = 'delivered';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::CONFIRMED => 'Confirmed',
            self::PREPARING => 'Preparing',
            self::READY => 'Ready',
            self::DELIVERED => 'Delivered',
            self::COMPLETED => 'Completed',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::PENDING => 'gray',
            self::CONFIRMED => 'info',
            self::PREPARING => 'primary',
            self::READY => 'warning',
            self::DELIVERED => 'success',
            self::COMPLETED => 'success',
            self::CANCELLED => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::PENDING => 'heroicon-o-clock',
            self::CONFIRMED => 'heroicon-o-check-circle',
            self::PREPARING => 'heroicon-o-beaker',
            self::READY => 'heroicon-o-exclamation-triangle',
            self::DELIVERED => 'heroicon-o-check-badge',
            self::COMPLETED => 'heroicon-o-check',
            self::CANCELLED => 'heroicon-o-x-circle',
        };
    }
}