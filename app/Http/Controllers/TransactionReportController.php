<?php

// File: app/Http/Controllers/TransactionReportController.php
namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class TransactionReportController extends Controller
{
    public function index()
    {
        // Ambil semua invoice, urutkan dari yang terbaru, dengan relasi ke pasien dan kasir
        $invoices = Invoice::with(['patient', 'cashier'])->latest()->paginate(15);
        return view('manager.transactions.index', compact('invoices'));
    }
}