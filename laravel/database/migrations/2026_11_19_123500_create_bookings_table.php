<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->string('booking_code')->unique();

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->restrictOnDelete();

            $table->foreignId('business_unit_id')
                ->constrained('business_units')
                ->restrictOnDelete();

            $table->string('title');
            $table->text('description')->nullable();

            $table->date('event_date')->nullable();
            $table->text('location')->nullable();

            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('unit_price', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->decimal('amount_paid', 15, 2)->default(0);

            $table->string('booking_status', 30)->default('pending');
            $table->string('payment_status', 30)->default('unpaid');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['booking_status', 'payment_status']);
            $table->index('event_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
