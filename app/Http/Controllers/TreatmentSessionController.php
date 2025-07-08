<?php

// File: app/Http/Controllers/TreatmentSessionController.php
namespace App\Http\Controllers;

use App\Models\TreatmentSession;
use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TreatmentSessionController extends Controller
{
    public function index()
    {
        // Ambil semua sesi untuk hari ini yang belum selesai
        // Ambil semua sesi untuk hari ini yang statusnya 'Sudah Check-in'
        $sessions = TreatmentSession::with('patient')
            ->whereDate('session_date', Carbon::today())
            ->where('status', 'Sudah Check-in') // <-- PERBAIKAN DI SINI
            ->orderBy('created_at', 'asc')
            ->get();
        
        return view('therapist.queue.index', compact('sessions'));
    }

    public function treat(TreatmentSession $session)
{
    // Hapus logika update status 'Dilayani'
    // Cukup tetapkan terapis yang akan melayani jika belum ada
    if (is_null($session->therapist_id)) {
        $session->update([
            'therapist_id' => Auth::id()
        ]);
    }

    // Ambil riwayat rekam medis pasien ini
    $pastRecords = MedicalRecord::where('patient_id', $session->patient_id)
                                     ->where('id', '!=', $session->medicalRecord->id ?? 0) // Jangan tampilkan record hari ini
                                     ->latest()
                                     ->get();

    return view('therapist.session.treat', compact('session', 'pastRecords'));
}
}
