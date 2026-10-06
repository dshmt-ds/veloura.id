<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate   = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $status    = $request->input('status', 'all');

        $query = Payment::with(['booking.customer', 'booking.staff', 'booking.items.service'])
            ->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $payments = $query->latest()->paginate(15)->withQueryString();

        // Ringkasan Statistik
        $totalRevenue = Payment::where('status', 'paid')
            ->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ])->sum('amount');

        $totalTransactions = Payment::whereBetween('created_at', [
            Carbon::parse($startDate)->startOfDay(),
            Carbon::parse($endDate)->endOfDay()
        ])->count();

        $successfulCount = Payment::where('status', 'paid')
            ->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ])->count();

        $pendingCount = Payment::where('status', 'pending')
            ->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ])->count();

        return view('admin.reports.index', [
            'payments'          => $payments,
            'startDate'         => $startDate,
            'endDate'           => $endDate,
            'selectedStatus'    => $status,
            'totalRevenue'      => $totalRevenue,
            'totalTransactions' => $totalTransactions,
            'successfulCount'   => $successfulCount,
            'pendingCount'      => $pendingCount,
        ]);
    }
}