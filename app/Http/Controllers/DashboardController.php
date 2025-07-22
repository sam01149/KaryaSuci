<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Patient;
use App\Models\TreatmentSession;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\InstallmentPayment;
use App\Models\Branch;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // --- PERHITUNGAN PENDAPATAN (Sudah Benar) ---
        $sessionRevenueToday = InstallmentPayment::whereHas('invoice', fn($q) => $q->where('payment_type', '!=', 'Penjualan Produk'))
            ->whereDate('created_at', Carbon::today())->sum('amount');
        $sessionRevenueThisMonth = InstallmentPayment::whereHas('invoice', fn($q) => $q->where('payment_type', '!=', 'Penjualan Produk'))
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');
        $productRevenueToday = Sale::whereDate('created_at', Carbon::today())->sum('total_amount');
        $productRevenueThisMonth = Sale::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_amount');
        $revenueToday = $sessionRevenueToday + $productRevenueToday;
        $revenueThisMonth = $sessionRevenueThisMonth + $productRevenueThisMonth;

        // --- STATISTIK PASIEN (Sudah Benar) ---
        $patientsToday = TreatmentSession::whereDate('session_date', Carbon::today())->distinct('patient_id')->count();
        $newPatientsThisMonth = Patient::whereMonth('created_at', Carbon::now()->month)->count();
        
        // --- FILTER RIWAYAT PENJUALAN (Sudah Benar) ---
        $salesQuery = Sale::with(['patient', 'cashier', 'items']);
        if ($request->filled('branch_id')) {
            $salesQuery->whereHas('cashier', fn($q) => $q->where('branch_id', $request->branch_id));
        }
        if ($request->filled('product_type')) {
            $salesQuery->whereHas('items', fn($q) => $q->where('product_type', $request->product_type));
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $salesQuery->whereBetween('created_at', [$request->start_date, $request->end_date . ' 23:59:59']);
        }
        $productSales = $salesQuery->latest()->limit(10)->get();
        $branches = Branch::orderBy('name')->get();

        // ==========================================================
        // == AWAL KODE BARU UNTUK DATA GRAFIK ==
        // ==========================================================
        
        // DATA UNTUK GRAFIK PENDAPATAN 7 HARI TERAKHIR
        $revenueLast7Days = InstallmentPayment::selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->where('created_at', '>=', now()->subDays(6)) // Mengambil data 7 hari termasuk hari ini
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
            
        $revenueLabels = $revenueLast7Days->pluck('date')->map(fn($date) => Carbon::parse($date)->format('d M'));
        $revenueData = $revenueLast7Days->pluck('total');

        // DATA UNTUK GRAFIK PIE TIPE PASIEN HARI INI
        $patientTypeToday = Invoice::whereDate('created_at', Carbon::today())
            ->selectRaw('payment_type, count(*) as count')
            ->groupBy('payment_type')
            ->pluck('count', 'payment_type');
        
        // ==========================================================
        // == AKHIR KODE BARU UNTUK DATA GRAFIK ==
        // ==========================================================

        return view('manager.dashboard', compact(
            'revenueToday', 
            'revenueThisMonth', 
            'patientsToday', 
            'newPatientsThisMonth',
            'productSales',
            'branches',
            'revenueLabels',      // <-- Kirim data label grafik
            'revenueData',        // <-- Kirim data nilai grafik
            'patientTypeToday'    // <-- Kirim data tipe pasien
        ));
    }
}