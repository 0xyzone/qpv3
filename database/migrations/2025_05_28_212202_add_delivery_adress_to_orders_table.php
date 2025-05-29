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
            $table->string('delivery_address')->nullable()->after('notes');
            $table->string('delivery_city')->nullable()->after('delivery_address');
            $table->string('delivery_phone')->nullable()->after('delivery_city');
            $table->timestamp('delivered_at')->nullable()->after('delivery_phone');
            $table->string('delivery_status')->default('pending')->after('delivered_at');
            $table->string('delivery_instructions')->nullable()->after('delivery_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
