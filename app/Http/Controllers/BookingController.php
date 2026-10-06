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
        if ($user->hasRole('customer') || $user->isCustomer()) {
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

        return view('admin.bookings.index', compact('bookings'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE (Khusus Admin)
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        // Mengambil user dengan role customer berdasarkan kolom 'role'
        $customers = User::where('role', 'customer')->orderBy('name')->get();

        if ($customers->isEmpty()) {
            $customers = User::orderBy('name')->get(); // Fallback jika belum ada yang diset role-nya
        }

        $staff = Staff::where('is_active', true)->orderBy('name')->get();
        $services = Service::where('status', 'active')->orderBy('name')->get();

        return view('admin.bookings.create', compact('customers', 'staff', 'services'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE (Bisa digunakan Customer maupun Admin)
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $user = auth()->user();

        // 1. Ambil customer_id: Jika customer login, paksa pakai ID-nya sendiri. Jika admin, ambil dari input form.
        $customerId = ($user->hasRole('customer') || $user->isCustomer()) ? $user->id : $request->input('customer_id');

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

        $request->merge(['customer_id' => $customerId]);

        // 4. Validasi Input
        $validated = $request->validate([
            'customer_id'    => ['required', 'exists:users,id'],
            'staff_id'       => ['required', 'exists:staffs,id'],
            'start_at'       => ['required', 'date'],
            'phone'          => ['nullable', 'string', 'max:20'],
            'payment_due_at' => ['nullable', 'date'],
            'customer_notes' => ['nullable', 'string'],
            'services'       => ['required', 'array', 'min:1'],
            'services.*'     => ['required', 'exists:services,id', 'distinct'],
        ]);

        DB::transaction(function () use ($validated) {
            if (!empty($validated['phone'])) {
                User::where('id', $validated['customer_id'])->update([
                    'phone' => $validated['phone'],
                ]);
            }

            $services = Service::whereIn('id', $validated['services'])->get();
            $totalAmount = $services->sum('price');
            $totalDuration = $services->sum('duration');

            $startAt = Carbon::parse($validated['start_at']);
            $endAt = $startAt->copy()->addMinutes($totalDuration);

            $booking = Booking::create([
                'booking_code'   => $this->generateBookingCode(),
                'customer_id'    => $validated['customer_id'],
                'staff_id'       => $validated['staff_id'],
                'start_at'       => $startAt,
                'end_at'         => $endAt,
                'total_amount'   => $totalAmount,
                'status'         => 'pending_payment',
                'payment_due_at' => $validated['payment_due_at'] ?? null,
                'customer_notes' => $validated['customer_notes'] ?? null,
            ]);

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

        $redirectRoute = ($user->hasRole('customer') || $user->isCustomer()) ? 'customer.bookings.index' : 'admin.bookings.index';

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
        if ($user->hasRole('customer') || $user->isCustomer()) {
            if ($booking->customer_id !== $user->id) {
                abort(403, 'Akses ditolak.');
            }

            $booking->load(['staff', 'items.service']);
            return view('customer.bookings.show', compact('booking'));
        }

        // Tampilan Admin
        $booking->load(['customer', 'staff', 'items.service']);
        return view('admin.bookings.show', compact('booking'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT (Khusus Admin)
    |--------------------------------------------------------------------------
    */
    public function edit(Booking $booking)
    {
        $booking->load('items');

        $customers = User::where('role', 'customer')->orderBy('name')->get();
        if ($customers->isEmpty()) {
            $customers = User::orderBy('name')->get();
        }

        $staff = Staff::where('is_active', true)->orderBy('name')->get();
        $services = Service::where('status', 'active')->orderBy('name')->get();

        return view('admin.bookings.edit', compact('booking', 'customers', 'staff', 'services'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE (Khusus Admin)
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
            $totalDuration = $services->sum('duration');

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
                    'duration_minutes' => $service->duration,
                ]);
            }
        });

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE (Hapus/Batal Booking)
    |--------------------------------------------------------------------------
    */
    public function destroy(Booking $booking)
    {
        $user = auth()->user();

        // Keamanan: Validasi bahwa customer hanya bisa menghapus booking miliknya
        if (($user->hasRole('customer') || $user->isCustomer()) && $booking->customer_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        $booking->delete();

        $redirectRoute = ($user->hasRole('customer') || $user->isCustomer()) ? 'customer.bookings.index' : 'admin.bookings.index';

        return redirect()->route($redirectRoute)->with('success', 'Booking berhasil dihapus.');
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