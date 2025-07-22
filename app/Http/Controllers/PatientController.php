<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Branch; 
use App\Models\TreatmentSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use App\Models\ActivityLog;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::with('branch'); // Selalu ambil data cabang terkait

        $user = Auth::user();
        $query = Patient::with('branch')->withCount('treatmentSessions');
        $patients = $query->latest()->paginate(10)->withQueryString();


        // HANYA filter berdasarkan cabang jika user BUKAN Admin atau Manajer
        if (!in_array($user->role, ['Admin', 'Manajer'])) {
            $query->where('branch_id', $user->branch_id);
        }

        // Lanjutkan dengan logika pencarian jika ada
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $patients = $query->latest()->paginate(10)->withQueryString();
        
        // ==========================================================
        // == BAGIAN YANG HILANG ADA DI SINI ==
        // ==========================================================
        // Ambil ID semua pasien yang ada di halaman ini
        $patientIdsOnPage = $patients->pluck('id');

        // Cari sesi yang sudah dibuat hari ini untuk pasien-pasien di halaman ini
        $checkedInPatientIds = TreatmentSession::whereIn('patient_id', $patientIdsOnPage)
            ->whereDate('session_date', Carbon::today())
            ->pluck('patient_id')
            ->all();
        // ==========================================================

        // Sekarang kirim SEMUA variabel yang dibutuhkan oleh view
        return view('patients.index', compact('patients', 'checkedInPatientIds'));

    }
    public function create()
    {
        $branches = Branch::orderBy('name', 'asc')->get();
        return view('patients.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'branch_id' => 'required|exists:branches,id',
        ]);

        Patient::create($validatedData);
        ActivityLog::create([
            'user_id' => auth()->id(),
            'branch_id' => $validatedData['branch_id'],
            'loggable_id' => Patient::latest()->first()->id, // Ambil ID pasien yang baru dibuat
            'loggable_type' => Patient::class,
            'action' => 'patient_created',
            'description' => auth()->user()->name . ' mendaftarkan pasien baru: ' . $validatedData['name'],
        ]);
        return redirect()->route('patients.index')->with('success', 'Pasien baru berhasil didaftarkan.');
    }

    public function show(Patient $patient)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['Admin', 'Manajer']) && $user->branch_id !== $patient->branch_id) {
            abort(403);
        }
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['Admin', 'Manajer']) && $user->branch_id !== $patient->branch_id) {
            abort(403);
        }
        
        $branches = Branch::orderBy('name', 'asc')->get();
        return view('patients.edit', compact('patient', 'branches'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'branch_id' => 'required|exists:branches,id',
        ]);

        $patient->update($validatedData);

        return redirect()->route('patients.index')->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy(Patient $patient)
    {
        if (! Gate::allows('delete-patient')) {
            abort(403);
        }
        
        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'Data pasien berhasil dihapus.');
    }
    public function printPDF(Patient $patient)
    {
        $data = [
            'patient' => $patient,
            'date' => now()->locale('id')->translatedFormat('d F Y')
        ];

        $pdf = PDF::loadView('patients.print', $data);

        // Nama file: Arsip-NamaPasien-Tanggal.pdf
        return $pdf->download('Arsip-' . $patient->name . '-' . date('Y-m-d') . '.pdf');
    }

    public function checkIn(Request $request, Patient $patient)
    {
        // Validasi dan pengecekan sesi yang sudah ada
        $request->validate([
            'check_in_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $todaySession = TreatmentSession::where('patient_id', $patient->id)
            ->whereDate('session_date', Carbon::today())
            ->first();

        if ($todaySession) {
            return redirect()->route('patients.index')->with('error', 'Pasien sudah check-in untuk hari ini.');
        }

        // Simpan foto
        $photoPath = $request->file('check_in_photo')->store('patient_checkins', 'public');
        $visitCount = TreatmentSession::where('patient_id', $patient->id)->count();

        // Buat Sesi Perawatan Baru
        TreatmentSession::create([
            'patient_id' => $patient->id,
            'branch_id' => $patient->branch_id, // <-- INI BARIS PENTING YANG MEMPERBAIKI ERROR
            'session_date' => Carbon::today(),
            'status' => 'Sudah Check-in',
            'patient_photo_path' => $photoPath,
            'visit_number' => $visitCount + 1,
        ]);

        ActivityLog::create([
        'user_id' => auth()->id(),
        'branch_id' => $patient->branch_id,
        'loggable_id' => $patient->id,
        'loggable_type' => Patient::class,
        'action' => 'patient_checked_in',
        'description' => auth()->user()->name . ' melakukan absensi pada pasien ' . $patient->name,
    ]);
        return redirect()->route('patients.index')->with('success', $patient->name . ' berhasil check-in dan masuk ke dalam antrian.');
    }   
    public function detail(Patient $patient)
{
    // Keamanan: Pastikan user hanya bisa melihat pasien di cabangnya (kecuali Admin/Manajer)
    $user = Auth::user();
    if (!in_array($user->role, ['Admin', 'Manajer']) && $user->branch_id !== $patient->branch_id) {
        abort(403);
    }

    // Ambil data pasien beserta semua riwayat sesinya, urutkan dari yang terbaru
    $patient->load(['treatmentSessions' => function ($query) {
        $query->latest();
    }]);

    return view('patients.detail', compact('patient'));
}
    public function archive(Request $request)
{
    $user = Auth::user();
    $query = Patient::with('branch')->latest(); // Mengambil data terbaru dulu

    // Filter 1: Hak Akses Berdasarkan Cabang
    if (!in_array($user->role, ['Admin', 'Manajer'])) {
        $query->where('branch_id', $user->branch_id);
    }

    // Filter 2: Berdasarkan Keyword Pencarian (Nama atau No. Induk)
    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('id', $request->search); // Asumsi No. Induk adalah ID Pasien
        });
    }

   

    // Filter 4: Berdasarkan Cabang (hanya untuk Admin/Manajer)
    if ($request->filled('branch_id') && in_array($user->role, ['Admin', 'Manajer'])) {
        $query->where('branch_id', $request->branch_id);
    }

    // Filter 5: Berdasarkan Jarak Tanggal Pendaftaran
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
    }

    // Ambil data dengan paginasi 20 per halaman
    $patients = $query->paginate(20)->withQueryString();

    // Ambil data cabang untuk dropdown filter (hanya jika Admin/Manajer)
    $branches = in_array($user->role, ['Admin', 'Manajer']) ? Branch::orderBy('name')->get() : collect();

    return view('patients.archive', compact('patients', 'branches'));
}
}