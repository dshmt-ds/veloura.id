<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Staff;

class LandingController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::where('is_active', true)
            ->with([
                'services' => function ($query) {
                    $query->where('status', 'active');
                }
            ])
            ->get();

        $services = Service::with('category')
            ->where('status', 'active')
            ->get();

        // Ambil staff aktif untuk ditampilkan di landing page
        $staffs = Staff::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('welcome', compact(
            'categories',
            'services',
            'staffs'
        ));
    }

    public function show(ServiceCategory $serviceCategory)
    {
        $serviceCategory->load([
            'services' => function ($query) {
                $query->where('status', 'active');
            }
        ]);

        return view(
            'show_categories',
            compact('serviceCategory')
        );
    }
}