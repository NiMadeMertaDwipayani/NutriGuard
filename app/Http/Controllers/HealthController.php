<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class HealthController extends Controller
{
    // Tampilkan Halaman Edit Profil Kesehatan
    public function edit()
    {
        // Ambil semua daftar penyakit untuk pilihan
        $diseases = Disease::all();
        
        // Ambil user yang sedang login
        $user = auth()->user();

        return view('health.edit', compact('diseases', 'user'));
    }

    // Simpan Pilihan Penyakit
    public function update(Request $request)
    {
        $request->validate([
            'diseases' => 'array', // Pastikan data berupa array/list
            'diseases.*' => 'exists:diseases,id', // Pastikan ID penyakitnya valid
        ]);

        $user = auth()->user();

        // Sync: Simpan pilihan baru, hapus pilihan lama yang tidak dicentang
        // Jika user tidak mencentang apa-apa, kita kirim array kosong []
        $user->diseases()->sync($request->input('diseases', []));

        return redirect()->route('dashboard')->with('success', 'Profil kesehatan berhasil diperbarui!');
    }

    // 3. Cetak PDF Pantangan
    public function exportPdf()
    {
        $user = auth()->user();
        
        // Ambil penyakit user beserta pantangannya
        // Kita filter agar hanya mengambil bahan yang statusnya 'danger' atau 'warning'
        $diseases = $user->diseases()->with(['ingredients' => function($query) {
            $query->wherePivotIn('status', ['danger', 'warning']);
        }])->get();

        // Load tampilan PDF
        $pdf = Pdf::loadView('health.pdf', compact('user', 'diseases'));

        // Download file
        return $pdf->download('Panduan-Sehat-NutriGuard.pdf');
    }

    /**
     * Menghapus SEMUA data penyakit yang terkait dengan user saat ini.
     */
    public function destroyAll(Request $request): RedirectResponse
    {
        // detach() tanpa argumen akan menghapus SEMUA relasi di tabel pivot untuk user ini
        $request->user()->diseases()->detach();

        return redirect()->route('dashboard')->with('success', 'Semua data kesehatan Anda berhasil dihapus. Status Anda kembali netral.');
    }

}
