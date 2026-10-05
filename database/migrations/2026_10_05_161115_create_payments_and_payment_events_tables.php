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
        // 10. Table: payments
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->string('payment_reference', 100)->unique();
            $table->string('gateway_provider', 50);
            $table->string('gateway_transaction_id', 150)->nullable();
            $table->string('payment_method', 50)->nullable();
            $table->decimal('amount', 12, 2);
            $table->char('currency', 3)->default('IDR');
            $table->enum('status', ['pending', 'paid', 'failed', 'expired', 'cancelled', 'refunded'])->default('pending');
            $table->text('checkout_url')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();

            // Unique constraint kombinasi gateway_provider & gateway_transaction_id
            $table->unique(['gateway_provider', 'gateway_transaction_id']);
        });

        // 11. Table: payment_events
        Schema::create('payment_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->nullable()->constrained('payments')->nullOnDelete();
            $table->string('gateway_provider', 50);
            $table->string('event_key', 191)->unique();
            $table->json('payload');
            $table->enum('processing_status', ['received', 'processed', 'failed'])->default('received');
            $table->dateTime('processed_at')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_events');
        Schema::dropIfExists('payments');
    }
};