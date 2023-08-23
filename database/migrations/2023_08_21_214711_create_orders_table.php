<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private const TABLE_NAME = 'orders';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('order_status_id')->constrained('order_statuses')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('payment_id')->unique()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->uuid()->unique();
            $table->json('products');
            $table->json('address');
            $table->unsignedBigInteger('delivery_fee')->nullable();
            $table->unsignedBigInteger('amount');
            $table->timestamps();
            $table->timestamp('shipped_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
