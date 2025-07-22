<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManajemenPasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $hariIni = now()->format('Y-m-d');
    $kunjunganHariIni = Kunjungan::whereDate('tanggal_kunjungan', $hariIni)->with('pasien')->get();
    return view('resepsionis.kedatangan.index', [
        'kunjunganHariIni' => $kunjunganHariIni,
        'tanggalHariIni' => now()->translatedFormat('l, d F Y')
    ]);
}

public function search(Request $request)
{
    $pasiens = Pasien::where('nama_pasien', 'LIKE', "%{$request->keyword}%")->limit(10)->get();
    return response()->json($pasiens);
}

public function checkIn(Request $request)
{
    $request->validate([
        'pasien_id' => 'required|exists:pasiens,id',
        'bukti_foto_checkin' => 'required|image|max:2048',
    ]);

    $pasien = Pasien::find($request->pasien_id);

    // Simpan foto bukti
    $path = $request->file('bukti_foto_checkin')->store('checkin_proofs', 'public');

    // Catat kunjungan
    Kunjungan::create([
        'pasien_id' => $pasien->id,
        'tanggal_kunjungan' => now(),
        'bukti_foto_checkin' => $path,
    ]);

    // Update jumlah kunjungan di master pasien
    $pasien->increment('jumlah_kunjungan');

    // Logika untuk pasien paket
    if ($pasien->memiliki_paket && $pasien->sisa_sesi_paket > 0) {
        $pasien->decrement('sisa_sesi_paket');
        // Pasien tidak perlu ke antrian pembayaran, bisa langsung ke fisioterapis
        // Tambahkan logika notifikasi ke fisioterapis di sini jika perlu
    } else {
        // Tambahkan pasien ke antrian pembayaran (jika tidak ada paket aktif)
        // Logika menambahkan ke antrian pembayaran
    }

    return redirect()->route('resepsionis.kedatangan.index')->with('success', 'Pasien berhasil di-check-in.');
}

}
