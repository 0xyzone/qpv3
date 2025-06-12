<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['bill_id']);
            $table->dropColumn([
                'subtotal',
                'discount_type',
                'discount_value',
                'discount_amount',
                'total_amount',
                'bill_id'
            ]);
        });
        Schema::table('bills', function (Blueprint $table) {
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->string('discount_type')->nullable();
            $table->decimal('discount_value', 10, 2)->nullable();
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('payment_method')->default('cash');
            $table->string('payment_status')->default('unpaid');
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->string('discount_type')->nullable();
            $table->decimal('discount_value', 10, 2)->nullable();
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->unsignedBigInteger('bill_id')->nullable();
        });

        Schema::table('bills', function (Blueprint $table) {
            $table->dropColumn([
                'subtotal',
                'discount_type',
                'discount_value',
                'discount_amount',
                'total_amount',
                'payment_method',
                'payment_status',
                'notes'
            ]);
        });
    }
};
