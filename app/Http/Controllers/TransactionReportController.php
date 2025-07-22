<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionReportController extends Controller
{
    public function index()
    {
        // Ambil semua invoice, urutkan dari yang terbaru
        // Eager load relasi untuk menghindari N+1 query problem
        $invoices = Invoice::with(['patient', 'cashier', 'sale.items', 'treatmentSession'])
                            ->latest()
                            ->paginate(20); // Gunakan paginate agar halaman tidak berat

        return view('manager.transactions.index', compact('invoices'));
    }
    public function printPDF()
    {
        // 1. Ambil data yang sama persis dengan method index()
        $invoices = Invoice::with(['patient', 'cashier', 'branch', 'sale.items'])->latest()->get();
        $data = [
            'invoices' => $invoices,
            'date' => date('d M Y')
        ];

        // 2. Buat PDF dari sebuah view baru
        $pdf = PDF::loadView('invoices.print', $data);

        // 3. Download PDF tersebut
        return $pdf->download('laporan-transaksi-'.date('Y-m-d').'.pdf');
    }
}