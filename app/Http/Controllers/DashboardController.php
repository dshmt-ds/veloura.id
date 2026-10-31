<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Staff;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->startOfDay();
        $tomorrow = $today->copy()->addDay();
        $paid = Payment::query()->where('status', 'paid');
        $paidToday = (clone $paid)->where('paid_at', '>=', $today)->where('paid_at', '<', $tomorrow);

        $stats = [
            'booking_hari_ini' => Booking::where('start_at', '>=', $today)->where('start_at', '<', $tomorrow)->count(),
            'pelanggan_baru' => User::where('role', 'customer')->where('created_at', '>=', $today)->where('created_at', '<', $tomorrow)->count(),
            'pendapatan_hari_ini' => (clone $paidToday)->sum('amount'),
            'rata_rata_transaksi' => (clone $paidToday)->avg('amount') ?? 0,
            'total_pelanggan' => User::where('role', 'customer')->count(),
            'total_layanan' => Service::count(),
            'total_transaksi' => Payment::count(),
            'total_pendapatan' => (clone $paid)->sum('amount'),
            'menunggu_pembayaran' => Booking::where('status', 'pending_payment')->count(),
            'pembayaran_pending' => Payment::where('status', 'pending')->count(),
            'staff_aktif' => Staff::where('is_active', true)->count(),
        ];

        $dailyRevenue = (clone $paid)
            ->where('paid_at', '>=', $today->copy()->subDays(6))
            ->where('paid_at', '<', $tomorrow)
            ->selectRaw('DATE(paid_at) as date, SUM(amount) as total')
            ->groupByRaw('DATE(paid_at)')
            ->pluck('total', 'date');

        $revenueChart = collect(range(6, 0))->map(function ($daysAgo) use ($today, $dailyRevenue) {
            $date = $today->copy()->subDays($daysAgo);

            return [
                'label' => $date->format('d/m'),
                'total' => (float) ($dailyRevenue[$date->toDateString()] ?? 0),
            ];
        });

        $latestBookings = Booking::with(['customer', 'staff', 'items'])
            ->latest()->orderByDesc('id')->limit(8)->get();

        return view('dashboard', compact('stats', 'revenueChart', 'latestBookings'));
    }
}
