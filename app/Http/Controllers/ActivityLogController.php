<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();
    $query = ActivityLog::with(['user', 'branch'])->latest();

    if (!in_array($user->role, ['Admin', 'Manajer'])) {
        $query->where('branch_id', $user->branch_id);
    }

    if ($request->filled('branch_id') && in_array($user->role, ['Admin', 'Manajer'])) {
        $query->where('branch_id', $request->branch_id);
    }

    // --- AWAL LOGIKA FILTER TANGGAL ---
    // Jika hanya tanggal mulai yang diisi
    if ($request->filled('start_date') && !$request->filled('end_date')) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }

    // Jika hanya tanggal selesai yang diisi
    if (!$request->filled('start_date') && $request->filled('end_date')) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }

    // Jika keduanya diisi
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('created_at', [$request->start_date, $request->end_date . ' 23:59:59']);
    }

    // Jika tidak ada filter tanggal, tampilkan hanya hari ini
    if (!$request->filled('start_date') && !$request->filled('end_date')) {
        $query->whereDate('created_at', today());
    }
    // --- AKHIR LOGIKA FILTER TANGGAL ---

    $logs = $query->paginate(10)->withQueryString();

    $groupedLogs = $logs->groupBy(function ($log) {
        return $log->created_at->format('l, d F Y');
    });

    $branches = in_array($user->role, ['Admin', 'Manajer']) ? Branch::orderBy('name')->get() : collect();

    return view('activity-logs.index', compact('logs', 'groupedLogs', 'branches'));
}
}