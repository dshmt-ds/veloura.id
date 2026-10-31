<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = Staff::with('services');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        // Filter status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            }

            if ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Filter layanan
        if ($request->filled('service_id')) {
            $serviceId = $request->service_id;

            $query->whereHas('services', function ($q) use ($serviceId) {
                $q->where('services.id', $serviceId);
            });
        }

        // Sorting
        switch ($request->sort) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;

            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;

            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;

            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $staffs = $query
            ->paginate(10)
            ->withQueryString();

        $services = Service::orderBy('name')->get();

        return view('admin.staffs.index', compact(
            'staffs',
            'services'
        ));
    }

    public function create()
    {
        $services = Service::orderBy('name')->get();

        return view('admin.staffs.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],

            'services' => [
                'nullable',
                'array',
            ],

            'services.*' => [
                'integer',
                'distinct',
                'exists:services,id',
            ],
        ]);

        DB::transaction(function () use ($validated, $request) {
            $staff = Staff::create([
                'name' => $validated['name'],
                'phone' => $validated['phone'] ?? null,
                'is_active' => $request->boolean('is_active'),
            ]);

            $staff->services()->sync($validated['services'] ?? []);
        });

        return redirect()
            ->route('admin.staffs.index')
            ->with('success', 'Staff berhasil ditambahkan.');
    }

    public function show(Staff $staff)
    {
        $staff->load([
            'services',
            'schedules' => function ($query) {
                $query->orderBy('schedule_date', 'desc');
            },
        ]);

        return view('admin.staffs.show', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        $services = Service::orderBy('name')->get();

        $staff->load('services');

        return view(
            'admin.staffs.edit',
            compact('staff', 'services')
        );
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],

            'services' => [
                'nullable',
                'array',
            ],

            'services.*' => [
                'integer',
                'distinct',
                'exists:services,id',
            ],
        ]);

        DB::transaction(function () use ($validated, $request, $staff) {
            $staff->update([
                'name' => $validated['name'],
                'phone' => $validated['phone'] ?? null,
                'is_active' => $request->boolean('is_active'),
            ]);

            $staff->services()->sync($validated['services'] ?? []);
        });

        return redirect()
            ->route('admin.staffs.index')
            ->with('success', 'Data staff berhasil diperbarui.');
    }

    public function destroy(Staff $staff)
    {
        $deleted = DB::transaction(function () use ($staff) {
            $staff = Staff::whereKey($staff->getKey())->lockForUpdate()->firstOrFail();

            if ($staff->bookings()->exists()) {
                return false;
            }

            return $staff->delete();
        });

        if (! $deleted) {
            return redirect()
                ->route('admin.staffs.index')
                ->with('error', 'Staff memiliki riwayat booking dan tidak dapat dihapus. Nonaktifkan staff melalui halaman edit.');
        }

        return redirect()
            ->route('admin.staffs.index')
            ->with('success', 'Staff berhasil dihapus.');
    }
}
