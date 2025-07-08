<?php

// File: app/Http/Controllers/PatientController.php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

use App\Models\TreatmentSession;
use Carbon\Carbon;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // 1. Logika untuk Pencarian Pasien
    $query = Patient::query();

    if ($request->has('search') && $request->search != '') {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // Mengambil data pasien dengan paginasi
    $patients = $query->latest()->paginate(10)->withQueryString();

    // 2. Logika untuk Mendapatkan Status Check-in Hari Ini
    // Ambil ID pasien yang ada di halaman ini saja
    $patientIdsOnPage = $patients->pluck('id');

    // Cari sesi yang sudah dibuat hari ini untuk pasien-pasien di halaman ini
    $checkedInSessions = TreatmentSession::whereIn('patient_id', $patientIdsOnPage)
        ->whereDate('session_date', Carbon::today())
        ->pluck('patient_id') // Ambil hanya ID pasiennya
        ->all(); // Konversi ke array biasa

    // Kirim semua data ke view
    return view('patients.index', [
        'patients' => $patients,
        'checkedInPatientIds' => $checkedInSessions, // Kirim array ID pasien yang sudah check-in
        'search' => $request->search // Kirim keyword pencarian untuk ditampilkan kembali di form
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi input dan simpan hasilnya ke dalam variabel
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'nullable|string',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
        ]);

        // 2. Gunakan data yang sudah tervalidasi untuk membuat pasien baru
        Patient::create($validatedData);

         // Redirect ke halaman daftar pasien dengan pesan sukses
        return redirect()->route('patients.index')
                         ->with('success', 'Pasien baru berhasil didaftarkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
         // 1. Validasi input dan simpan hasilnya ke dalam variabel
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'nullable|string',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
        ]);

        // 2. Gunakan data yang sudah tervalidasi untuk mengupdate data pasien
        $patient->update($validatedData);

        // Redirect ke halaman daftar pasien dengan pesan sukses
        return redirect()->route('patients.index')
                         ->with('success', 'Data pasien berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        // Hapus data pasien
        $patient->delete();

        // Redirect ke halaman daftar pasien dengan pesan sukses
        return redirect()->route('patients.index')
                         ->with('success', 'Data pasien berhasil dihapus.');
    }
   public function checkIn(Request $request, Patient $patient)
{
    // 1. Validasi, termasuk validasi untuk file gambar
    $request->validate([
        'patient_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Wajib, harus gambar, max 2MB
    ]);
    // Validasi dengan named error bag
    $request->validateWithBag('checkin', [
        'patient_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Cek apakah pasien sudah check-in hari ini
    $todaySession = TreatmentSession::where('patient_id', $patient->id)
        ->whereDate('session_date', Carbon::today())
        ->first();

    if ($todaySession) {
        return redirect()->route('patients.index')->with('error', 'Pasien sudah check-in untuk hari ini.');
    }

    // 2. Simpan foto yang di-upload
    $photoPath = $request->file('patient_photo')->store('patient_checkins', 'public');

    // Hitung kunjungan sebelumnya
    $visitCount = TreatmentSession::where('patient_id', $patient->id)->count();

    // 3. Buat sesi baru dengan menyertakan path foto dan nomor kunjungan
    TreatmentSession::create([
        'patient_id' => $patient->id,
        'session_date' => Carbon::today(),
        'status' => 'Sudah Check-in',
        'patient_photo_path' => $photoPath, // Simpan path foto
        'visit_number' => $visitCount + 1, // Kunjungan ke- (total sesi sebelumnya + 1)
    ]);

    return redirect()->route('patients.index')->with('success', $patient->name . ' berhasil check-in dan masuk ke dalam antrian.');
}

}