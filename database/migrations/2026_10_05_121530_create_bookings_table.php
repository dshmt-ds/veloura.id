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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code', 30)->unique();
            $table->foreignId('customer_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignId('staff_id')
                ->constrained('staff')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->enum('status', [
                'pending_payment',
                'confirmed',
                'in_progress',
                'completed',
                'cancelled',
                'expired',
                'no_show',
            ])->default('pending_payment');
            $table->dateTime('payment_due_at')->nullable();
            $table->text('customer_notes')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();

            $table->index('customer_id');
            $table->index('staff_id');
            $table->index('status');
            $table->index('start_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
