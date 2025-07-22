<?php

// File: app/Http/Controllers/ProductSaleController.php
namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\ProductSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;

class ProductSaleController extends Controller
{
    public function create()
    {
        // Ambil semua pasien untuk dropdown
        $patients = Patient::orderBy('name', 'asc')->get();
        return view('cashier.products.create', compact('patients'));
    }

      public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'product_type' => 'required|in:Obat,Alat',
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            // Tambahkan validasi untuk bukti bayar jika diperlukan
            'receipt_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Langkah 1: Simpan data penjualan produk (sudah Anda lakukan)
        $productSale = ProductSale::create([
            'patient_id' => $validated['patient_id'],
            'cashier_id' => Auth::id(),
            'product_type' => $validated['product_type'],
            'product_name' => $validated['product_name'],
            'quantity' => $validated['quantity'],
            'total_price' => $validated['total_price'],
        ]);

        // Langkah 2: Buat Invoice yang terkait dengan penjualan ini (BAGIAN BARU)
        if ($productSale) {
            $receiptPath = null;
            if ($request->hasFile('receipt_photo')) {
                $receiptPath = $request->file('receipt_photo')->store('receipts', 'public');
            }

            Invoice::create([
                'patient_id' => $productSale->patient_id,
                'cashier_id' => $productSale->cashier_id,
                'amount' => $productSale->total_price,
                'payment_type' => 'Umum', // Asumsi pembayaran produk selalu 'Umum'
                'receipt_photo_path' => $receiptPath,
                'treatment_session_id' => null, // Dibuat null karena ini bukan dari sesi treatment
                // Jika Anda sudah menambahkan product_sale_id ke tabel invoices:
                'product_sale_id' => $productSale->id,
            ]);
        }

        return redirect()->route('cashier.products.create')->with('success', 'Penjualan ' . $validated['product_name'] . ' berhasil dicatat.');
    }
}