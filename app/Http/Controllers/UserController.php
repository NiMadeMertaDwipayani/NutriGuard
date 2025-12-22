<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Daftar User
    public function index()
    {
        // Ambil semua user, urutkan terbaru
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    // Form Tambah User (Admin menambahkan akun)
    public function create()
    {
        return view('admin.users.create');
    }

    // Simpan User Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,user'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat!');
    }

    // Form Edit
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Update User
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'in:admin,user'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Logika Cerdas Password
        if ($request->filled('password')) {
            $request->validate([
                // 1. Password Utama: Cuma cek panjang & kerumitan (HAPUS 'confirmed' DARI SINI)
                'password' => [Rules\Password::defaults()],
                
                // 2. Konfirmasi: Cek Wajib Diisi DAN Cek Kesamaan di sini
                'password_confirmation' => [
                    'required_with:password', 
                    'same:password' // <-- Logika "Match" dipindah ke sini
                ] 
            ], [
                // Custom Pesan Error
                'password_confirmation.required_with' => 'Konfirmasi password wajib diisi jika Anda mengganti password.',
                'password_confirmation.same' => 'Konfirmasi password tidak cocok dengan password baru.',
            ]);
            
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data User berhasil diperbarui!');
    }

    // Hapus User
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }
        
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }
}

