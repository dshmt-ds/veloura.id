<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\StaffSchedule;
use Illuminate\Http\Request;

class StaffScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = StaffSchedule::with('staff');
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('staff', function ($staffQuery) use ($search) {
                    $staffQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('phone', 'like', '%' . $search . '%');
                })
                ->orWhere('note', 'like', '%' . $search . '%'); 
            });
        }

        if ($request->filled('staff_id')) {
            $query->where('staff_id', $request->staff_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('schedule_date')) {
            $query->whereDate('schedule_date', $request->schedule_date);
        }

        switch ($request->sort) {
            case 'date_asc':
                $query->orderBy('schedule_date', 'asc')->orderBy('start_time', 'asc');
                break;

            case 'staff_name_asc':
                $query->whereHas('staff')->join('staffs', 'staff_schedules.staff_id', '=', 'staffs.id')
                    ->orderBy('staffs.name', 'asc')
                    ->select('staff_schedules.*');
                break;

            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;

            case 'date_desc':
            default:
                $query->orderBy('schedule_date', 'desc')->orderBy('start_time', 'asc');
                break;
        }

        $schedules = $query
            ->paginate(10)
            ->withQueryString();

        $staffs = Staff::orderBy('name')->get();

        return view('admin.staff-schedules.index', compact(
            'schedules',
            'staffs'
        ));
    }

    public function create()
    {
        $staffs = Staff::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'admin.staff-schedules.create',
            compact('staffs')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_id' => [
                'required',
                'exists:staffs,id',
            ],

            'schedule_date' => [
                'required',
                'date',
            ],

            'start_time' => [
                'required',
                'date_format:H:i',
            ],

            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        StaffSchedule::create($validated);

        return redirect()
            ->route('staff-schedules.index')
            ->with('success', 'Jadwal staff berhasil ditambahkan.');
    }

    public function show(StaffSchedule $staffSchedule)
    {
        $staffSchedule->load('staff');

        return view(
            'admin.staff-schedules.show',
            compact('staffSchedule')
        );
    }

    public function edit(StaffSchedule $staffSchedule)
    {
        $staffs = Staff::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'admin.staff-schedules.edit',
            compact('staffSchedule', 'staffs')
        );
    }

    public function update(
        Request $request,
        StaffSchedule $staffSchedule
    ) {
        $validated = $request->validate([
            'staff_id' => [
                'required',
                'exists:staffs,id',
            ],

            'schedule_date' => [
                'required',
                'date',
            ],

            'start_time' => [
                'required',
                'date_format:H:i',
            ],

            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        $staffSchedule->update($validated);

        return redirect()
            ->route('staff-schedules.index')
            ->with('success', 'Jadwal staff berhasil diperbarui.');
    }

    public function destroy(StaffSchedule $staffSchedule)
    {
        $staffSchedule->delete();

        return redirect()
            ->route('staff-schedules.index')
            ->with('success', 'Jadwal staff berhasil dihapus.');
    }
}