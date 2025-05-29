<?php

use App\OrderTypes;
use App\OrderStatuses;
use App\PaymentMethods;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();

            $table->string('order_type')->default(OrderTypes::DINE_IN->value);
            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->string('discount_type')->nullable();
            $table->decimal('discount_value', 10, 2)->default(0.00);
            $table->decimal('total_amount', 10, 2)->default(0.00);
            
            $table->string('payment_method')->default(PaymentMethods::CASH->value);
            $table->string('payment_status')->default('unpaid');
            
            $table->longText('notes')->nullable();

            $table->string('status')->default(OrderStatuses::PENDING->value);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
