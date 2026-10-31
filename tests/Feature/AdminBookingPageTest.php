<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBookingPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_create_booking_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('admin.bookings.create'))
            ->assertOk()
            ->assertSee('Tambah Pemesanan')
            ->assertSee(route('admin.bookings.store'), false);
    }

    public function test_customer_cannot_open_admin_create_booking_page(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $this->actingAs($customer)
            ->get(route('admin.bookings.create'))
            ->assertForbidden();
    }
}
