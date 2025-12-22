<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Disease;
use Illuminate\Http\Request;

class DiseaseController extends Controller
{
    public function index(Request $request)
    {
        // Mulai Query
        $query = Disease::latest();

        // Jika ada pencarian
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Eksekusi
        $diseases = $query->get();

        return view('admin.diseases.index', compact('diseases'));
    }

    // Halaman Form Tambah (DIPERBARUI)
    public function create()
    {
        // kirim data ingredients agar bisa dipilih saat buat penyakit baru
        $ingredients = \App\Models\Ingredient::all();
        return view('admin.diseases.create', compact('ingredients'));
    }

    // Proses Simpan Data (DIPERBARUI)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:diseases,name',
            'description' => 'nullable|string',
            'ingredients' => 'array', // Validasi array pantangan
        ]);

        // 1. Buat Penyakitnya dulu
        $disease = Disease::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // 2. Simpan Relasi Pantangan (Jika ada yang dipilih)
        if ($request->has('ingredients')) {
            $syncData = [];
            foreach ($request->ingredients as $ingredientId => $status) {
                if ($status) { // Jika status tidak kosong (bukan netral)
                    $syncData[$ingredientId] = ['status' => $status];
                }
            }
            // Attach ke penyakit yang baru dibuat
            $disease->ingredients()->sync($syncData);
        }

        return redirect()->route('admin.diseases.index')
            ->with('success', 'Data Penyakit dan Pantangan berhasil ditambahkan!');
    }

    // Halaman Form Edit (MODIFIKASI)
    public function edit(Disease $disease)
    {
        // Ambil semua bahan makanan untuk ditampilkan di form
        $ingredients = Ingredient::all();
        
        return view('admin.diseases.edit', compact('disease', 'ingredients'));
    }

    // Proses Update Data + Relasi (MODIFIKASI BESAR)
    public function update(Request $request, Disease $disease)
    {
        // Validasi Nama & Deskripsi
        $request->validate([
            'name' => 'required|string|max:255|unique:diseases,name,' . $disease->id,
            'description' => 'nullable|string',
            // Validasi array ingredients (opsional tapi bagus)
            'ingredients' => 'array',
        ]);

        // Update Data Utama Penyakit
        $disease->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // PROSES RELASI MANY-TO-MANY (Logic Inti)
        // Kita siapkan array untuk disinkronkan
        $syncData = [];

        // Loop semua input dari form
        if ($request->has('ingredients')) {
            foreach ($request->ingredients as $ingredientId => $status) {
                // Jika statusnya TIDAK kosong (bukan 'netral'), kita simpan
                if ($status) {
                    $syncData[$ingredientId] = ['status' => $status];
                }
            }
        }

        // Fungsi sync() sangat pintar:
        // - Dia akan MENAMBAH relasi baru
        // - Dia akan MENGHAPUS relasi lama yang tidak ada di list $syncData
        // - Dia akan UPDATE status jika berubah
        $disease->ingredients()->sync($syncData);

        return redirect()->route('admin.diseases.index')
            ->with('success', 'Aturan Penyakit berhasil diperbarui!');
    }

    // Proses Hapus Data
    public function destroy(Disease $disease)
    {
        $disease->delete();

        return redirect()->route('admin.diseases.index')
            ->with('success', 'Data Penyakit berhasil dihapus!');
    }
}
