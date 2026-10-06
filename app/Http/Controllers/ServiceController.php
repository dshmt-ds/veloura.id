<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Menampilkan daftar layanan.
     */
    public function index(Request $request)
    {
        $query = Service::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sort = $request->get('sort', 'latest');

        switch ($sort) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;

            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;

            case 'price_low':
                $query->orderBy('price', 'asc');
                break;

            case 'price_high':
                $query->orderBy('price', 'desc');
                break;

            case 'duration_low':
                $query->orderBy('duration', 'asc');
                break;

            case 'duration_high':
                $query->orderBy('duration', 'desc');
                break;

            default:
                $query->latest();
                break;
        }

        $services = $query
            ->paginate(10)
            ->withQueryString();

        $categories = ServiceCategory::where('is_active', true)
            ->orderBy('name', 'asc')
            ->pluck('name'); 

        $totalServices = Service::count();
        $activeServices = Service::where('status', 'active')->count();
        $inactiveServices = Service::where('status', 'inactive')->count();
        $averagePrice = Service::where('status', 'active')->avg('price') ?? 0;

        return view('admin.services.index', compact(
            'services',
            'categories',
            'totalServices',
            'activeServices',
            'inactiveServices',
            'averagePrice'
        ));
    }

    /**
     * Form tambah layanan.
     */
    public function create()
    {
        $categories = ServiceCategory::where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.services.create', compact('categories'));
    }

    /**
     * Simpan layanan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'category' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'integer', 'min:1', 'max:1440'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ], [
            'name.required' => 'Nama layanan wajib diisi.',
            'category.required' => 'Kategori wajib dipilih.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'duration.required' => 'Durasi wajib diisi.',
            'duration.integer' => 'Durasi harus berupa angka.',
            'duration.min' => 'Durasi minimal 1 menit.',
        ]);

        Service::create($validated);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail layanan.
     */
    public function show(Service $service)
    {
        return view('admin.services.show', compact('service'));
    }

    /**
     * Form edit layanan.
     */
    public function edit(Service $service)
    {
        $categories = ServiceCategory::where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.services.edit', compact('service', 'categories'));
    }

    /**
     * Update data layanan.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'category' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'integer', 'min:1', 'max:1440'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $service->update($validated);

        return redirect()
            ->route('services.index')
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    /**
     * Hapus layanan.
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()
            ->route('services.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }

    /**
     * Toggle status aktif/nonaktif layanan.
     */
    public function toggleStatus(Service $service)
    {
        $newStatus = $service->status === 'active' ? 'inactive' : 'active';
        
        $service->update([
            'status' => $newStatus,
        ]);

        $message = $newStatus === 'active'
            ? 'Layanan berhasil diaktifkan.'
            : 'Layanan berhasil dinonaktifkan.';

        return redirect()
            ->back()
            ->with('success', $message);
    }
}