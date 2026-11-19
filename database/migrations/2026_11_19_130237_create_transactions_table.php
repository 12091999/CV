<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // Kode transaksi unik
            $table->string('transaction_code')->unique();

            // Relasi booking: nullable untuk transaksi non-booking
            $table->foreignId('booking_id')
                ->nullable()
                ->constrained('bookings')
                ->restrictOnDelete();

            // Setiap transaksi harus memiliki unit bisnis
            $table->foreignId('business_unit_id')
                ->constrained('business_units')
                ->restrictOnDelete();

            // Income atau expense
            $table->string('type', 20);

            // Kategori transaksi
            $table->string('category', 100);

            // Informasi transaksi
            $table->string('description');
            $table->decimal('amount', 15, 2);

            // Tanggal dan metode pembayaran
            $table->date('transaction_date');
            $table->string('payment_method', 30)->nullable();

            // Nomor referensi pembayaran
            $table->string('reference_number')->nullable();

            // Status transaksi
            $table->string('status', 20)->default('completed');

            // Catatan tambahan
            $table->text('notes')->nullable();

            // User yang mencatat transaksi
            $table->foreignId('recorded_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['type', 'status']);
            $table->index('transaction_date');
            $table->index(['business_unit_id', 'transaction_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
