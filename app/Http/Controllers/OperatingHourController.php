<?php

namespace App\Http\Controllers;

use App\Models\OperatingHour;
use Illuminate\Http\Request;

class OperatingHourController extends Controller
{
    public function index()
    {
        $operatingHours = OperatingHour::orderBy('day_of_week')->get();

        return view(
            'admin.operating-hours.index',
            compact('operatingHours')
        );
    }

    public function create()
    {
        return view('admin.operating-hours.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'day_of_week' => [
                'required',
                'integer',
                'between:1,7',
                'unique:operating_hours,day_of_week',
            ],

            'open_time' => [
                'nullable',
                'date_format:H:i',
            ],

            'close_time' => [
                'nullable',
                'date_format:H:i',
            ],

            'is_closed' => [
                'nullable',
                'boolean',
            ],
        ]);

        OperatingHour::create([
            'day_of_week' => $validated['day_of_week'],
            'open_time' => $validated['open_time'] ?? null,
            'close_time' => $validated['close_time'] ?? null,
            'is_closed' => $request->boolean('is_closed'),
        ]);

        return redirect()
            ->route('operating-hours.index')
            ->with('success', 'Jam operasional berhasil ditambahkan.');
    }

    public function edit(OperatingHour $operatingHour)
    {
        return view(
            'admin.operating-hours.edit',
            compact('operatingHour')
        );
    }

    public function update(
        Request $request,
        OperatingHour $operatingHour
    ) {
        $validated = $request->validate([
            'day_of_week' => [
                'required',
                'integer',
                'between:1,7',
                'unique:operating_hours,day_of_week,' .
                    $operatingHour->id,
            ],

            'open_time' => [
                'nullable',
                'date_format:H:i',
            ],

            'close_time' => [
                'nullable',
                'date_format:H:i',
            ],

            'is_closed' => [
                'nullable',
                'boolean',
            ],
        ]);

        $operatingHour->update([
            'day_of_week' => $validated['day_of_week'],
            'open_time' => $validated['open_time'] ?? null,
            'close_time' => $validated['close_time'] ?? null,
            'is_closed' => $request->boolean('is_closed'),
        ]);

        return redirect()
            ->route('operating-hours.index')
            ->with('success', 'Jam operasional berhasil diperbarui.');
    }

    public function destroy(OperatingHour $operatingHour)
    {
        $operatingHour->delete();

        return redirect()
            ->route('operating-hours.index')
            ->with('success', 'Jam operasional berhasil dihapus.');
    }
}