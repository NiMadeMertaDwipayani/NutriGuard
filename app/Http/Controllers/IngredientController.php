<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // untuk hapus gambar

class IngredientController extends Controller
{
    //TAMPILKAN DAFTAR
    public function index()
    {
        $ingredients = Ingredient::latest()->get();
        return view('admin.ingredients.index', compact('ingredients'));
    }

    // FORM CREATE
    public function create()
    {
        return view('admin.ingredients.create');
    }

    // 3. SIMPAN DATA ( + GAMBAR )
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'calories' => 'required|integer|min:0',
            'protein' => 'required|numeric|min:0',
            'carbs' => 'required|numeric|min:0',
            'fat' => 'required|numeric|min:0',
        ]);

        // 2. Siapkan data dasar
        $data = [
            'name' => $request->name,
            'calories' => $request->calories,
            'protein' => $request->protein,
            'carbs' => $request->carbs,
            'fat' => $request->fat,
            'image' => null, // Default null (jika tidak ada gambar)
        ];

        // 3. Logika Gambar (Jika ada upload, isi variable image)
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('ingredients', 'public');
        }

        // 4. Simpan ke Database
        Ingredient::create($data);

        return redirect()->route('admin.ingredients.index')
            ->with('success', 'Bahan Makanan berhasil ditambahkan!');
    }

    // FORM EDIT
    public function edit(Ingredient $ingredient)
    {
        return view('admin.ingredients.edit', compact('ingredient'));
    }

    // UPDATE DATA ( + GANTI GAMBAR )
    public function update(Request $request, Ingredient $ingredient)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'calories' => 'required|integer|min:0',
            'protein' => 'required|numeric|min:0',
            'carbs' => 'required|numeric|min:0',
            'fat' => 'required|numeric|min:0',
        ]);

        // 2. Siapkan data dasar (selain gambar)
        $data = [
            'name' => $request->name,
            'calories' => $request->calories,
            'protein' => $request->protein,
            'carbs' => $request->carbs,
            'fat' => $request->fat,
        ];

        // 3. Logika Gambar (Hanya update jika ada file baru)
        if ($request->hasFile('image')) {
            // Simpan gambar baru
            $data['image'] = $request->file('image')->store('ingredients', 'public');
            
            // Opsional: Hapus gambar lama agar hemat storage
            if ($ingredient->image) { Storage::disk('public')->delete($ingredient->image); }
        }

        // 4. Eksekusi Update
        // Laravel otomatis hanya mengupdate kolom yang ada di dalam array $data
        $ingredient->update($data);

        return redirect()->route('admin.ingredients.index')
            ->with('success', 'Bahan Makanan berhasil diperbarui!');
    }

    // HAPUS DATA ( + HAPUS GAMBAR )
    public function destroy(Ingredient $ingredient)
    {
        // Hapus gambar dari penyimpanan agar tidak menuh-menuhin server
        if ($ingredient->image) {
            Storage::disk('public')->delete($ingredient->image);
        }

        $ingredient->delete();

        return redirect()->route('admin.ingredients.index')
            ->with('success', 'Bahan Makanan berhasil dihapus!');
    }
}
