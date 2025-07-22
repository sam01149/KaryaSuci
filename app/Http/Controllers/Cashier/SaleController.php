<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Sale;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Throwable;

class SaleController extends Controller
{
    public function create(Request $request)
{
    $patients = collect(); // Defaultnya koleksi kosong

    // Jika ada query pencarian, cari pasien berdasarkan nama atau ID
    if ($request->has('search') && $request->search != '') {
        $searchTerm = $request->search;
        $patients = Patient::where('name', 'like', '%' . $searchTerm . '%')
            ->orWhere('id', $searchTerm)
            ->limit(10)
            ->get();
    }

    return view('cashier.sales.create', compact('patients'));
}

    public function store(Request $request)
    {
        
         $validated = $request->validate([
        'patient_id'        => 'required|exists:patients,id',
        'receipt_photo'     => 'required|image|max:2048',
        'items'             => 'required|array|min:1',
        'items.*.product_name' => 'required|string|max:255',
        'items.*.product_type' => 'required|in:Obat,Alat',
        'items.*.quantity'  => 'required|integer|min:1',
        'items.*.price'     => 'required|numeric|min:0',
        'notes' => 'nullable|string|max:1000',
        
    ]);


        try {
            
           $invoice =  DB::transaction(function () use ($validated, $request) {
                $patient = \App\Models\Patient::find($validated['patient_id']);

                // 1. Hitung total harga
                $totalAmount = collect($validated['items'])->sum(fn($item) => $item['quantity'] * $item['price']);
                
                // 2. Buat data master Sale
                $sale = Sale::create([
                    'patient_id'    => $validated['patient_id'],
                    'cashier_id'    => auth()->id(),
                    'total_amount'  => $totalAmount,
                ]);
                
                // 3. Simpan setiap item yang terhubung ke Sale
                foreach ($validated['items'] as $item) {
                    $sale->items()->create($item);
                }
                
                // 4. Simpan foto bukti pembayaran
                $photoPath = $request->file('receipt_photo')->store('receipts', 'public');
                
                // 5. Terakhir, buat satu Invoice yang mencatat semuanya
               $newInvoice=  \App\Models\Invoice::create([
                'patient_id'        => $validated['patient_id'],
                'cashier_id'        => auth()->id(),
                'total_due'         => $totalAmount,
                'amount_paid'       => $totalAmount, // Penjualan produk diasumsikan langsung lunas
                'payment_status'    => 'Lunas',
                'payment_type'      => 'Penjualan Produk',
                'receipt_photo_path' => $photoPath,
                'sale_id'           => $sale->id,
                'notes'             => $validated['notes'] ?? null,
                'branch_id'         => $patient->branch_id, // <-- TAMBAHKAN BARIS INI
            ]);
              \App\Models\ActivityLog::create([
                'user_id' => auth()->id(),
                'branch_id' => $patient->branch_id,
                'loggable_id' =>$newInvoice->id,
                'loggable_type' => \App\Models\Invoice::class,
                'action' => 'product_sold',
                'description' => auth()->user()->name . ' mencatat penjualan ' . implode(', ', array_column($validated['items'], 'product_name')) . ' (' . implode(', ', array_column($validated['items'], 'product_type')) . ') sebesar ' . number_format($totalAmount) . ' untuk pasien ' . $patient->name,
            ]);
            });
        } catch (Throwable $e) {
            dd('Invoice error: ' . $e->getMessage());
        }
        
        return redirect()->route('invoices.index')->with('success', 'Transaksi penjualan berhasil disimpan.');
    }
}