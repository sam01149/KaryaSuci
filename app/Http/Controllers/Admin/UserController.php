<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Branch;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('branch')
                    ->where('role', '!=', 'Admin')
                    ->orderBy('name', 'asc')
                    ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat pegawai baru.
     */
    public function create()
    {
        $branches = Branch::orderBy('name', 'asc')->get();
        return view('admin.users.create', compact('branches'));
    }

    /**
     * Menyimpan data pegawai baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'phone_number' => ['required', 'string', 'max:20'],
            'role' => ['required', 'string', 'in:Manajer,Resepsionis,Fisioterapis,Kasir'],
            'branch_id' => ['required', 'exists:branches,id'], // <-- TAMBAHKAN VALIDASI INI
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'branch_id' => $request->branch_id, // <-- TAMBAHKAN PENYIMPANAN INI
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'Pegawai baru berhasil ditambahkan.');
    }
    public function edit(User $user)
    {
        $branches = Branch::orderBy('name', 'asc')->get();
        return view('admin.users.edit', compact('user', 'branches'));
    }
    public function update(Request $request, User $user)
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        'phone_number' => ['required', 'string', 'max:20'],
        'role' => ['required', 'string', 'in:Manajer,Resepsionis,Fisioterapis,Kasir'],
        'branch_id' => ['required', 'exists:branches,id'], // <-- TAMBAHKAN VALIDASI INI
        'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
    ]);

    $updateData = [
        'name' => $request->name,
        'email' => $request->email,
        'phone_number' => $request->phone_number,
        'role' => $request->role,
        'branch_id' => $request->branch_id, // <-- TAMBAHKAN PENYIMPANAN INI
    ];

    if (!empty($request->password)) {
        $updateData['password'] = Hash::make($request->password);
    }

    $user->update($updateData);

    return redirect()->route('users.index')->with('success', 'Data pegawai berhasil diperbarui.');
}
    public function destroy(User $user)
    {
        // Jalankan perintah hapus pada user yang dipilih
        $user->delete();

        // Redirect kembali ke halaman daftar dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'Data pegawai berhasil dihapus.');
    }
    
}