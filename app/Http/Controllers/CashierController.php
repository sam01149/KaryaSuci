<?php

// File: app/Http/Controllers/CashierController.php
namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\TreatmentSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\DB; // <-- TAMBAHKAN BARIS INI
use Throwable; // <-- TAMBAHKAN INI JUGA UNTUK BLOK TRY-CATCH
use Carbon\Carbon;
use App\Models\ActivityLog;
class CashierController extends Controller
{
    public function index()
    {
        // Ambil semua sesi untuk hari ini yang statusnya 'Selesai'
        // AMBIL DATA USER YANG SEDANG LOGIN
        $user = Auth::user();

        // Mulai query
        $query = TreatmentSession::with('patient')
            ->whereDate('session_date', Carbon::today())
            ->where('status', 'Selesai');

        // Terapkan filter cabang jika user bukan Admin atau Manajer
        if (!in_array($user->role, ['Admin', 'Manajer'])) {
            $query->where('branch_id', $user->branch_id);
        }

        // Ambil hasil query
        $sessions = $query->orderBy('updated_at', 'asc')->get();

        return view('cashier.queue.index', compact('sessions'));
    }

 public function processPayment(Request $request, TreatmentSession $session)
    {
        // Validasi data umum yang selalu ada
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_type' => 'required|in:Umum,Paket',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            $invoice = DB::transaction(function () use ($validated, $request, $session) {
                
                $invoiceData = [
                    'treatment_session_id' => $session->id,
                    'patient_id' => $session->patient_id,
                    'cashier_id' => Auth::id(),
                    'branch_id' => $session->branch_id,
                    'total_due' => $validated['amount'],
                    'amount_paid' => 0,
                    'payment_status' => 'Belum Lunas',
                    'payment_type' => $validated['payment_type'],
                    'notes' => $validated['notes'] ?? null,
                ];

                // --- LOGIKA TERPISAH UNTUK PAKET ---
                if ($validated['payment_type'] === 'Paket') {
                    $packageData = $request->validate([
                        'package_total_sessions' => 'required|integer|min:1',
                        'program_proof_photo' => 'required|image|max:2048',
                    ]);

                    $photoPath = $request->file('program_proof_photo')->store('program_proofs', 'public');
                    
                    $session->patient->update([
                        'program_status' => 'Paket',
                        'is_package_active' => true,
                        'program_proof_photo_path' => $photoPath,
                        'package_total_sessions' => $packageData['package_total_sessions'],
                        'package_sessions_remaining' => $packageData['package_total_sessions'] - 1,
                    ]);
                }

                $newInvoice = Invoice::create($invoiceData);
                $session->update(['status' => 'Menunggu Pembayaran']);
                ActivityLog::create([
                'user_id' => auth()->id(),
                'branch_id' => $session->branch_id,
                'loggable_id' => $newInvoice->id,
                'loggable_type' => Invoice::class,
                'action' => 'invoice_created',
                'description' => auth()->user()->name . ' membuat Invoice #' . $newInvoice->id . ' (' . $newInvoice->payment_type . ') untuk pasien ' . $session->patient->name,
            ]);
                        
                return $newInvoice;
            });

        } catch (Throwable $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->route('invoices.show', $invoice->id)->with('success', 'Tagihan berhasil dibuat. Silakan proses pembayaran.');
    }
// Tambahkan method ini di dalam CashierController
public function confirmPackageSession(TreatmentSession $session)
{
    $patient = $session->patient;

    // Keamanan: Pastikan ini benar-benar pasien paket aktif
    if (!$patient->is_package_active || $patient->program_status !== 'Paket') {
        return redirect()->route('cashier.queue.index')->with('error', 'Pasien ini bukan peserta program paket aktif.');
    }
    if ($patient->package_sessions_remaining > 0) {
        $patient->decrement('package_sessions_remaining');
    }
    if ($patient->package_sessions_remaining <= 0) {
        $patient->update([
            'is_package_active' => false,
            'program_status' => 'Umum', // Kembalikan status ke Umum
            'package_total_sessions' => 0, // Reset jumlah sesi
        ]);
    }
    

    // Cek apakah invoice paketnya masih belum lunas
    $packageInvoice = Invoice::where('patient_id', $patient->id)
                            ->where('payment_type', 'Paket')
                            ->where('payment_status', '!=', 'Lunas')
                            ->latest()->first();

    // Update status sesi menjadi 'Selesai' (karena tidak ada pembayaran)
    $session->update(['status' => 'Paket Dikonfirmasi']);


    // Jika ada tagihan yang belum lunas, arahkan ke sana
    if ($packageInvoice) {
        return redirect()->route('invoices.show', $packageInvoice->id)
                         ->with('info', 'Konfirmasi kunjungan berhasil. Pasien masih memiliki tagihan paket yang belum lunas.');
    }

    // Jika sudah lunas, kembalikan ke antrian dengan pesan sukses
    return redirect()->route('cashier.queue.index')->with('success', 'Kunjungan untuk ' . $patient->name . ' berhasil dikonfirmasi.');
}

// Method baru untuk update program pasien
    public function updatePatientProgram(Request $request, Patient $patient)
{
    // Validasi sudah tidak ada di sini lagi
    $patientData = ['program_status' => 'Paket', 'is_package_active' => true];

    if ($request->hasFile('program_proof_photo')) {
        $proofPath = $request->file('program_proof_photo')->store('program_proofs', 'public');
        $patientData['program_proof_photo_path'] = $proofPath;
    }

    $patient->update($patientData);
}
   

}
