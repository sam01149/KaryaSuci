<?php

// File: app/Http/Controllers/CashierController.php
namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\TreatmentSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;

use Carbon\Carbon;

class CashierController extends Controller
{
    public function index()
    {
        // Ambil semua sesi untuk hari ini yang statusnya 'Selesai'
        $sessions = TreatmentSession::with('patient')
            ->whereDate('session_date', Carbon::today())
            ->where('status', 'Selesai')
            ->orderBy('updated_at', 'asc')
            ->get();

        return view('cashier.queue.index', compact('sessions'));
    }

    public function processPayment(Request $request, TreatmentSession $session)
{
    $validated = $request->validate([
        'amount' => 'required|numeric|min:0',
        'payment_type' => 'required|in:Umum,Paket',
        'receipt_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validasi bukti bayar
    ]);

    // Simpan foto bukti pembayaran
    $receiptPath = $request->file('receipt_photo')->store('receipts', 'public');

    // Buat invoice baru
    Invoice::create([
        'treatment_session_id' => $session->id,
        'patient_id' => $session->patient_id,
        'cashier_id' => Auth::id(),
        'amount' => $validated['amount'],
        'payment_type' => $validated['payment_type'],
        'receipt_photo_path' => $receiptPath, // Simpan path foto
    ]);

    // Update status sesi menjadi 'Sudah Bayar'
    $session->update(['status' => 'Sudah Bayar']);

    // Jika pasien mendaftar program paket, update data pasiennya
    if ($request->has('register_program') && $request->program_status == 'Paket') {
        $this->updatePatientProgram($request, $session->patient);
    }

    return redirect()->route('cashier.queue.index')->with('success', 'Pembayaran untuk ' . $session->patient->name . ' berhasil diproses.');
}

// Method baru untuk update program pasien
    public function updatePatientProgram(Request $request, Patient $patient)
    {
        $request->validate([
        'program_status' => 'required|in:Umum,Paket',
        'program_proof_photo' => 'required_if:program_status,Paket|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $patientData = ['program_status' => $request->program_status];

        if ($request->hasFile('program_proof_photo')) {
            $proofPath = $request->file('program_proof_photo')->store('program_proofs', 'public');
            $patientData['program_proof_photo_path'] = $proofPath;
        }

        $patient->update($patientData);
    }
    public function history()
    {
        $invoices = Invoice::with(['patient', 'productSale'])
            ->where('cashier_id', Auth::id())
            ->whereDate('created_at', Carbon::today())
            ->latest()
            ->get();

        return view('cashier.history.index', compact('invoices'));
    }
}
