<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bill extends Model
{
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    // Helper to calculate total
    public function getTotalAttribute(): float
    {
        return $this->orders->sum('total_amount');
    }

    public function calculateTotals()
    {
        $this->subtotal = $this->orders->sum(function($order) {
            return $order->orderItems->sum('total_price');
        });

        if ($this->discount_type === 'percentage') {
            $this->discount_amount = $this->subtotal * ($this->discount_value / 100);
        } else {
            $this->discount_amount = $this->discount_value ?? 0;
        }

        $this->total_amount = $this->subtotal - $this->discount_amount;
        $this->save();
    }
}
