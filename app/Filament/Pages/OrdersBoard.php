<?php

namespace App\Filament\Pages;

use App\Models\Order;
use App\OrderStatuses;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;
use Illuminate\Database\Eloquent\Builder;

class OrdersBoard extends KanbanBoard
{
    protected static string $model = Order::class;
    protected static string $statusEnum = OrderStatuses::class;
    public bool $disableEditModal = true;
    protected static string $recordTitleAttribute = 'id';

    protected function getEloquentQuery(): Builder
    {
        return static::$model::query()->where('created_at', '>=', now()->subDays(1));
    }
}
