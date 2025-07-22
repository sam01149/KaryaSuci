<?php

namespace App\Http\Controllers;

use App\Models\TreatmentSession;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TreatmentSessionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = TreatmentSession::with('patient')
            ->whereDate('session_date', Carbon::today())
            ->where('status', 'Sudah Check-in');

        // ==========================================================
        // == PERBAIKAN 1: Filter antrian berdasarkan cabang terapis ==
        // ==========================================================
        // Hanya Admin dan Manajer yang bisa melihat semua antrian
        if (!in_array($user->role, ['Admin', 'Manajer'])) {
            $query->where('branch_id', $user->branch_id);
        }
        
        $sessions = $query->orderBy('created_at', 'asc')->get();
        
        return view('therapist.queue.index', compact('sessions'));
    }

    public function treat(TreatmentSession $session)
    {
        $user = Auth::user();

        // ==========================================================
        // == PERBAIKAN 2: Tambahkan pengecekan keamanan ==
        // ==========================================================
        if (!in_array($user->role, ['Admin', 'Manajer']) && $user->branch_id !== $session->branch_id) {
            abort(403, 'Anda tidak memiliki akses ke sesi di cabang ini.');
        }

        // Cukup tetapkan terapis yang akan melayani jika belum ada
        if (is_null($session->therapist_id)) {
            $session->update([
                'therapist_id' => $user->id
            ]);
        }

        // Ambil riwayat rekam medis pasien ini
        $pastRecords = MedicalRecord::where('patient_id', $session->patient_id)
            ->where('id', '!=', $session->medicalRecord->id ?? 0)
            ->latest()
            ->get();

        return view('therapist.session.treat', compact('session', 'pastRecords'));
    }
}