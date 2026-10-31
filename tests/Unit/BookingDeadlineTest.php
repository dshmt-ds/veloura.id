<?php

namespace Tests\Unit;

use App\Models\Booking;
use Tests\TestCase;

class BookingDeadlineTest extends TestCase
{
    public function test_default_deadline_is_twenty_four_hours_after_creation(): void
    {
        $booking = new Booking;
        $booking->created_at = '2026-10-31 10:00:00';

        $this->assertSame('2026-11-01 10:00:00', $booking->payment_deadline->format('Y-m-d H:i:s'));
        $this->assertSame('2026-10-31 10:00:00', $booking->created_at->format('Y-m-d H:i:s'));
    }

    public function test_explicit_deadline_is_preserved(): void
    {
        $booking = new Booking(['payment_due_at' => '2026-11-02 09:00:00']);
        $this->assertSame('2026-11-02 09:00:00', $booking->payment_deadline->format('Y-m-d H:i:s'));
    }
}
