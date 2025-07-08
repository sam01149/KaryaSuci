<?php

// File: app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Patient;
use App\Models\TreatmentSession;
use Illuminate\Http\Request;
use App\Models\ProductSale;

use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Data Pendapatan
        $revenueToday = Invoice::whereDate('created_at', Carbon::today())->sum('amount');
        $productSales = ProductSale::with('patient', 'cashier') // Ambil relasi untuk info detail
                                   ->latest() // Urutkan dari yang terbaru
                                   ->get();
        $revenueThisMonth = Invoice::whereMonth('created_at', Carbon::now()->month)
                                    ->whereYear('created_at', Carbon::now()->year)
                                    ->sum('amount');

        // Data Pasien
        $patientsToday = TreatmentSession::whereDate('session_date', Carbon::today())->distinct('patient_id')->count();
        $newPatientsThisMonth = Patient::whereMonth('created_at', Carbon::now()->month)
                                       ->whereYear('created_at', Carbon::now()->year)
                                       ->count();

        // Pasien Umum vs Paket hari ini
        $patientTypeToday = Invoice::whereDate('created_at', Carbon::today())
                            ->selectRaw('payment_type, count(*) as count')
                            ->groupBy('payment_type')
                            ->pluck('count', 'payment_type');
        


        return view('manager.dashboard', compact(
            'revenueToday', 
            'revenueThisMonth', 
            'patientsToday', 
            'newPatientsThisMonth',
            'patientTypeToday',
            'productSales'
        ));
    }
}