<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private const TABLE_NAME = 'order_statuses';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('title');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
