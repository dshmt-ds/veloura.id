<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ServiceCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = ServiceCategory::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $categories = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.service_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.service_categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:service_categories,name',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
            'name.max' => 'Nama kategori maksimal 100 karakter.',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        ServiceCategory::create($validated);

        return redirect()
            ->route('admin.service-categories.index')
            ->with('success', 'Kategori layanan berhasil ditambahkan.');
    }

    public function show(ServiceCategory $serviceCategory)
    {
        return view('admin.service_categories.show', compact('serviceCategory'));
    }

    public function edit(ServiceCategory $serviceCategory)
    {
        return view('admin.service_categories.edit', compact('serviceCategory'));
    }

    public function update(Request $request, ServiceCategory $serviceCategory)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('service_categories', 'name')
                    ->ignore($serviceCategory->id),
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
            'name.max' => 'Nama kategori maksimal 100 karakter.',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $serviceCategory->update($validated);

        return redirect()
            ->route('service-categories.index')
            ->with('success', 'Kategori layanan berhasil diperbarui.');
    }

    public function destroy(ServiceCategory $serviceCategory)
    {
        $serviceCategory->delete();

        return redirect()
            ->route('service-categories.index')
            ->with('success', 'Kategori layanan berhasil dihapus.');
    }
}