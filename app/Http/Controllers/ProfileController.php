<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // 1. Validasi data dasar (Nama & Email)
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // 2. Validasi Khusus Avatar
        $request->validate([
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ], [
            // Pesan jika file lebih besar dari 2MB (Validasi Laravel)
            'avatar.max' => 'Maaf, ukuran foto profil maksimal 2 MB.',
            
            // Pesan jika file SANGAT BESAR hingga ditolak Server (Penyebab pesan "failed to upload")
            'avatar.uploaded' => 'Gagal mengupload. Ukuran foto mungkin terlalu besar (Maks 2 MB).',
            
            // Pesan format
            'avatar.image' => 'File yang diupload harus berupa gambar.',
            'avatar.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
        ]);

        // 3. Proses Upload (Hanya jalan jika validasi lolos dan ada file)
        if ($request->hasFile('avatar')) {
            // Hapus foto lama
            if ($request->user()->avatar) {
                Storage::disk('public')->delete($request->user()->avatar);
            }

            // Simpan foto baru
            $path = $request->file('avatar')->store('avatars', 'public');
            $request->user()->avatar = $path;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Hapus foto profil user.
     */
    public function destroyAvatar(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->avatar) {
            // Hapus file fisik di storage
            Storage::disk('public')->delete($user->avatar);
            
            // Kosongkan kolom di database
            $user->update(['avatar' => null]);
        }

        return back()->with('status', 'avatar-deleted'); // Kembali ke halaman profile
    }

}
