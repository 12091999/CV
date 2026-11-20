<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_unit_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->decimal('price', 15, 2)->default(0);
            $table->string('unit_label', 50)->default('unit');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['business_unit_id', 'slug']);
            $table->index(['business_unit_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_items');
    }
};
