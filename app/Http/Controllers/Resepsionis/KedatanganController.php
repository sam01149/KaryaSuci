<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\TreatmentSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KedatanganController extends Controller
{
    /**
     * Menampilkan halaman utama kedatangan pasien.
     */
    public function index()
    {
        // Ambil semua data sesi perawatan (kunjungan) untuk hari ini
        $kunjunganHariIni = TreatmentSession::whereDate('created_at', today())
            ->with('patient') // Ambil juga data pasien terkait
            ->latest()
            ->get();

        // Tampilkan view dan kirim data kunjungan
        return view('resepsionis.kedatangan.index', [
            'kunjunganHariIni' => $kunjunganHariIni,
            'tanggalHariIni' => now()->translatedFormat('l, d F Y')
        ]);
    }

    /**
     * Mencari pasien berdasarkan nama untuk check-in.
     */
    public function search(Request $request)
    {
        $keyword = $request->input('keyword', '');

        if (empty($keyword)) {
            return response()->json([]);
        }

        // Cari pasien yang namanya cocok dengan keyword
        $pasiens = Patient::where('name', 'LIKE', "%{$keyword}%")
            ->select('id', 'name', 'created_at as tanggal_registrasi') // Ambil data yang dibutuhkan
            ->limit(10)
            ->get();

        return response()->json($pasiens);
    }

    /**
     * Memproses check-in pasien.
     */
    public function checkIn(Request $request)
    {
        // 1. Validasi data yang masuk
        $request->validate([
            'pasien_id' => 'required|exists:patients,id',
            'bukti_foto' => 'required|image|max:2048', // Wajib foto, maks 2MB
        ]);

        $pasien = Patient::find($request->pasien_id);

        DB::transaction(function () use ($request, $pasien) {
            // 2. Hitung ini kunjungan ke berapa
            // Berdasarkan jumlah sesi perawatan yang sudah ada + 1
            $jumlahKunjungan = TreatmentSession::where('patient_id', $pasien->id)->count() + 1;

            // 3. Simpan foto bukti check-in
            $pathFoto = $request->file('bukti_foto')->store('checkin_proofs', 'public');

            // 4. Buat record baru di treatment_sessions
            TreatmentSession::create([
                'patient_id' => $pasien->id,
                'user_id' => auth()->id(), // ID resepsionis yang melakukan check-in
                'visit_number' => $jumlahKunjungan,
                'check_in_photo' => $pathFoto,
                // Kolom lain bisa diisi sesuai kebutuhan, misal 'status'
                'status' => 'waiting_for_therapist',
            ]);
        });

        return redirect()->route('resepsionis.kedatangan.index')->with('success', 'Pasien ' . $pasien->name . ' berhasil di-check-in.');
    }
}