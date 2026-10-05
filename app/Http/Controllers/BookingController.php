<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Service;
use App\Models\Staff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $user = auth()->user();

        // Customer hanya dapat melihat booking miliknya sendiri
        if ($user->hasRole('customer')) {
            $bookings = Booking::with(['customer', 'staff', 'items'])
                ->where('customer_id', $user->id)
                ->latest()
                ->paginate(10)
                ->withQueryString();

            return view('customer.bookings.index', compact('bookings'));
        }

        // Query untuk Admin
        $query = Booking::with(['customer', 'staff', 'items'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($customer) use ($search) {
                      $customer->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(10)->withQueryString();

        return view('bookings.index', compact('bookings'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $customers = User::orderBy('name')->get();
        $staff = Staff::where('is_active', true)->orderBy('name')->get();
        $services = Service::where('status', 'active')->orderBy('name')->get();

        return view('bookings.create', compact('customers', 'staff', 'services'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        // 1. Ambil customer ID berdasarkan Siapa yang Login vs Input Form Admin
        $user = auth()->user();
        $customerId = $user->hasRole('customer') ? $user->id : $request->input('customer_id');

        // 2. Format input start_at jika dikirim terpisah (booking_date & booking_time)
        if (!$request->has('start_at') && $request->filled('booking_date') && $request->filled('booking_time')) {
            $request->merge([
                'start_at' => $request->booking_date . ' ' . $request->booking_time,
            ]);
        }

        // 3. Format input services jika hanya dikirim tunggal (string/int)
        if ($request->has('services') && !is_array($request->services)) {
            $request->merge([
                'services' => [$request->services],
            ]);
        }

        // Merge customer_id yang sudah aman ke dalam request sebelum validasi
        $request->merge(['customer_id' => $customerId]);

        // 4. Validasi
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:users,id'],
            'staff_id'    => ['required', 'exists:staffs,id'],
            'start_at'    => ['required', 'date'],
            'phone'       => ['nullable', 'string', 'max:20'],
            'payment_due_at' => ['nullable', 'date'],
            'customer_notes' => ['nullable', 'string'],
            'services'    => ['required', 'array', 'min:1'],
            'services.*'  => ['required', 'exists:services,id', 'distinct'],
        ]);

        DB::transaction(function () use ($validated) {
            // Update No HP Customer jika diisi
            if (!empty($validated['phone'])) {
                User::where('id', $validated['customer_id'])->update([
                    'phone' => $validated['phone'],
                ]);
            }

            // Hitung kalkulasi berdasarkan Service
            $services = Service::whereIn('id', $validated['services'])->get();
            $totalAmount = $services->sum('price');
            $totalDuration = $services->sum('duration'); // Menggunakan kolom 'duration' di model Service

            $startAt = Carbon::parse($validated['start_at']);
            $endAt = $startAt->copy()->addMinutes($totalDuration);

            // Buat Booking Utama
            $booking = Booking::create([
                'booking_code'    => $this->generateBookingCode(),
                'customer_id'     => $validated['customer_id'],
                'staff_id'        => $validated['staff_id'],
                'start_at'        => $startAt,
                'end_at'          => $endAt,
                'total_amount'    => $totalAmount,
                'status'          => 'pending_payment',
                'payment_due_at'  => $validated['payment_due_at'] ?? null,
                'customer_notes'  => $validated['customer_notes'] ?? null,
            ]);

            // Buat Item Booking (Koreksi nama kolom 'duration_minutes' pada BookingItem)
            foreach ($services as $service) {
                BookingItem::create([
                    'booking_id'       => $booking->id,
                    'service_id'       => $service->id,
                    'service_name'     => $service->name,
                    'price'            => $service->price,
                    'duration_minutes' => $service->duration, 
                ]);
            }
        });

        $redirectRoute = auth()->user()->hasRole('customer') ? 'customer.bookings.index' : 'admin.bookings.index';

        return redirect()->route($redirectRoute)->with('success', 'Booking berhasil dibuat.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show(Booking $booking)
    {
        $user = auth()->user();

        // Customer hanya boleh melihat booking miliknya
        if ($user->hasRole('customer')) {
            if ($booking->customer_id !== $user->id) {
                abort(403, 'Akses ditolak.');
            }

            $booking->load(['staff', 'items.service']);
            return view('customer.bookings.show', compact('booking'));
        }

        $booking->load(['customer', 'staff', 'items.service']);
        return view('bookings.show', compact('booking'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit(Booking $booking)
    {
        $booking->load('items');

        $customers = User::orderBy('name')->get();
        $staff = Staff::where('is_active', true)->orderBy('name')->get();
        $services = Service::where('status', 'active')->orderBy('name')->get();

        return view('bookings.edit', compact('booking', 'customers', 'staff', 'services'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Booking $booking)
    {
        if (!$request->has('start_at') && $request->filled('booking_date') && $request->filled('booking_time')) {
            $request->merge([
                'start_at' => $request->booking_date . ' ' . $request->booking_time,
            ]);
        }

        if ($request->has('services') && !is_array($request->services)) {
            $request->merge([
                'services' => [$request->services],
            ]);
        }

        $validated = $request->validate([
            'customer_id'         => ['required', 'exists:users,id'],
            'staff_id'            => ['required', 'exists:staffs,id'],
            'start_at'            => ['required', 'date'],
            'status'              => ['required', 'in:pending_payment,confirmed,in_progress,completed,cancelled,expired,no_show'],
            'payment_due_at'      => ['nullable', 'date'],
            'customer_notes'      => ['nullable', 'string'],
            'cancellation_reason' => ['nullable', 'string'],
            'services'            => ['required', 'array', 'min:1'],
            'services.*'          => ['required', 'exists:services,id', 'distinct'],
        ]);

        DB::transaction(function () use ($validated, $booking) {
            $services = Service::whereIn('id', $validated['services'])->get();

            $totalAmount = $services->sum('price');
            $totalDuration = $services->sum('duration'); // Koreksi: Menggunakan 'duration' dari Service

            $startAt = Carbon::parse($validated['start_at']);
            $endAt = $startAt->copy()->addMinutes($totalDuration);

            $booking->update([
                'customer_id'         => $validated['customer_id'],
                'staff_id'            => $validated['staff_id'],
                'start_at'            => $startAt,
                'end_at'              => $endAt,
                'total_amount'        => $totalAmount,
                'status'              => $validated['status'],
                'payment_due_at'      => $validated['payment_due_at'] ?? null,
                'customer_notes'      => $validated['customer_notes'] ?? null,
                'cancellation_reason' => $validated['cancellation_reason'] ?? null,
                'cancelled_at'        => $validated['status'] === 'cancelled' ? now() : null,
                'completed_at'        => $validated['status'] === 'completed' ? now() : null,
            ]);

            // Re-sync booking items
            $booking->items()->delete();

            foreach ($services as $service) {
                BookingItem::create([
                    'booking_id'       => $booking->id,
                    'service_id'       => $service->id,
                    'service_name'     => $service->name,
                    'price'            => $service->price,
                    'duration_minutes' => $service->duration, // Koreksi nama atribut
                ]);
            }
        });

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | GENERATE BOOKING CODE
    |--------------------------------------------------------------------------
    */
    private function generateBookingCode(): string
    {
        do {
            $code = 'BK-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4));
        } while (Booking::where('booking_code', $code)->exists());

        return $code;
    }
}