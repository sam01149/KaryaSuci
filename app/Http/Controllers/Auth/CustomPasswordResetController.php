<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class CustomPasswordResetController extends Controller
{
    public function showRequestForm()
    {
        return view('auth.forgot-password-custom');
    }

    public function sendResetRequest(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'phone_number' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();
        $admin = User::where('role', 'Admin')->first();

        if (!$admin) {
            return back()->withErrors(['email' => 'Sistem tidak dapat menemukan Admin untuk memproses permintaan.']);
        }

        $subject = "Permintaan Reset Password untuk " . $user->name;
        $body = "Pengguna dengan detail di bawah ini meminta untuk mereset password:\n\n" .
                "Nama: " . $user->name . "\n" .
                "Email: " . $user->email . "\n" .
                "Nomor Telepon: " . $request->phone_number . "\n\n" .
                "Mohon segera hubungi nomor tersebut untuk memberikan password baru.";

        Message::create([
            'sender_id' => $user->id,
            'recipient_id' => $admin->id,
            'subject' => $subject,
            'body' => $body,
        ]);

        return redirect()->route('login')->with('status', 'Permintaan reset password Anda telah berhasil dikirim ke Admin. Silakan tunggu konfirmasi melalui telepon.');
    }
}