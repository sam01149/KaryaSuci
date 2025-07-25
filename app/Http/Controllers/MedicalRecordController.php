<?php

// File: app/Http/Controllers/MedicalRecordController.php
namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\TreatmentSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;
class MedicalRecordController extends Controller
{
    public function store(Request $request, TreatmentSession $session)
    {
        $validated = $request->validate([
            'assessment' => 'required|string',
            'diagnosis' => 'required|string',
            'treatment_plan' => 'required|string',
        ]);

        // Buat rekam medis baru
        MedicalRecord::create([
            'treatment_session_id' => $session->id,
            'patient_id' => $session->patient_id,
            'therapist_id' => Auth::id(),
            'assessment' => $validated['assessment'],
            'diagnosis' => $validated['diagnosis'],
            'treatment_plan' => $validated['treatment_plan'],
        ]);

        // Update status sesi menjadi 'Selesai'
        $session->update(['status' => 'Selesai']);
        ActivityLog::create([
        'user_id' => auth()->id(),
        'branch_id' => $session->branch_id,
        'loggable_id' => $session->patient_id,
        'loggable_type' => \App\Models\Patient::class,
        'action' => 'session_finished',
        'description' => auth()->user()->name . ' menyelesaikan sesi terapi untuk pasien ' . $session->patient->name,
    ]);
        return redirect()->route('therapist.queue.index')->with('success', 'Sesi untuk pasien ' . $session->patient->name . ' telah selesai.');
    }
}