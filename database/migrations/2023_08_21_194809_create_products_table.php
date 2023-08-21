<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private const TABLE_NAME = 'products';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('category_uuid')
                ->constrained('categories', 'uuid')
                ->cascadeOnUpdate()
                ->cascadeOnUpdate();
            $table->uuid()->unique();
            $table->string('title');
            $table->unsignedBigInteger('price');
            $table->text('description');
            $table->json('metadata');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
