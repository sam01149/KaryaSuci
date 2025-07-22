<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message; // Model Message akan kita buat nanti

class ForgotPasswordRequestController extends Controller
{
    public function create()
    {
        return view('auth.forgot-password-request');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'nomor_telepon' => 'required|string',
        ]);

        // Cari admin pertama
        $admin = User::where('role', 'admin')->first();

        if ($admin) {
            // Pesan otomatis yang akan dibuat
            $subject = "Permintaan Reset Password";
            $body = "Seorang pengguna telah meminta reset password.\n\n" .
                    "Email: " . $request->email . "\n" .
                    "Nomor Telepon: " . $request->nomor_telepon . "\n\n" .
                    "Mohon untuk membuat password baru dan mengirimkannya ke nomor telepon pengguna.";

            // Simpan pesan ke database (Model Message akan dibuat di Tahap 4)
            Message::create([
                'sender_id' => 0, // ID 0 untuk sistem
                'receiver_id' => $admin->id,
                'subject' => $subject,
                'body' => $body,
            ]);

            return back()->with('status', 'Permintaan Anda telah dikirim ke admin. Silakan tunggu konfirmasi melalui telepon.');
        }

        return back()->withErrors(['email' => 'Tidak dapat menemukan admin untuk memproses permintaan.']);
    }
}