<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InstallmentPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Throwable;
use App\Models\ActivityLog;


class InvoiceController extends Controller
{
   public function index(Request $request) // Tambahkan Request
{
    $user = Auth::user();
    $query = Invoice::with(['patient', 'cashier', 'branch'])->latest();

    if (!in_array($user->role, ['Admin', 'Manajer'])) {
        $query->where('branch_id', $user->branch_id);
    }

    // --- AWAL LOGIKA FILTER TANGGAL ---
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('created_at', [$request->start_date, $request->end_date . ' 23:59:59']);
    } else {
        // Defaultnya, tampilkan data hari ini
        $query->whereDate('created_at', today());
    }
    // --- AKHIR LOGIKA FILTER TANGGAL ---

    $invoices = $query->paginate(20)->withQueryString();
    $invoices->load(['installmentPayments' => fn($q) => $q->latest()->first()]);

    return view('invoices.index', compact('invoices'));
}
    public function show(Invoice $invoice)
    {
        // Eager load relasi untuk efisiensi
        $invoice->load(['patient', 'installmentPayments.cashier']);
        return view('invoices.show', compact('invoice'));
    }

    public function storeInstallment(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'receipt_photo' => 'required|image|max:2048',
            'notes' => 'nullable|string|max:1000', 

        ]);

        // Pastikan jumlah cicilan tidak melebihi sisa tagihan
        $remainingBalance = $invoice->total_due - $invoice->amount_paid;
        if ($validated['amount'] > $remainingBalance) {
            return back()->withErrors(['amount' => 'Jumlah pembayaran melebihi sisa tagihan.']);
        }

        try {
            DB::transaction(function () use ($validated, $request, $invoice) {
                // Simpan foto
                $photoPath = $request->file('receipt_photo')->store('receipts', 'public');

                // Catat pembayaran cicilan
                InstallmentPayment::create([
                    'invoice_id' => $invoice->id,
                    'cashier_id' => auth()->id(),
                    'amount' => $validated['amount'],
                    'receipt_photo_path' => $photoPath,
                    'notes' => $validated['notes'] ?? null,
                ]);

                // Update data di invoice utama
                $newAmountPaid = $invoice->amount_paid + $validated['amount'];
                $newStatus = ($newAmountPaid >= $invoice->total_due) ? 'Lunas' : 'Cicilan';

                $invoice->update([
                    'amount_paid' => $newAmountPaid,
                    'payment_status' => $newStatus,
                ]);
                ActivityLog::create([
                'user_id' => auth()->id(),
                'branch_id' => $invoice->branch_id,
                'loggable_id' => $invoice->id,
                'loggable_type' => Invoice::class,
                'action' => 'installment_paid',
                'description' => auth()->user()->name . ' mencatat pembayaran ' . $newStatus . ' sebesar Rp ' . number_format($validated['amount']) . ' untuk Invoice #' . $invoice->id,
            ]);
            });
        } catch (Throwable $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->route('invoices.show', $invoice->id)->with('success', 'Pembayaran cicilan berhasil disimpan.');
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