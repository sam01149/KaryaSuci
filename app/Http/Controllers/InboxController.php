<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InboxController extends Controller
{
    public function index()
    {
        $messages = Message::where('recipient_id', Auth::id())
                            ->with('sender')
                            ->latest()
                            ->paginate(15);

        return view('inbox.index', compact('messages'));
    }
    public function show(Message $message)
{
    // Keamanan: Pastikan pengguna yang login adalah penerima pesan
    if (auth()->id() !== $message->recipient_id) {
        abort(403, 'UNAUTHORIZED ACTION.');
    }

    // Tandai pesan sebagai sudah dibaca jika belum
    if (is_null($message->read_at)) {
        $message->update(['read_at' => now()]);
    }

    return view('inbox.show', compact('message'));
}
}