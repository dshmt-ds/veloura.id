<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'booking_hari_ini' => 8,
            'menunggu_konfirmasi' => 3,
            'transaksi_selesai' => 24,
            'pendapatan' => 4850000,
        ];

        return view('dashboard', compact('stats'));
    }
}
