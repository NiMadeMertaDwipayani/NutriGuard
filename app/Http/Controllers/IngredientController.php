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
        $request->validate([
            'name' => 'required|string|max:255|unique:ingredients,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi Gambar
        ]);

        $data = $request->all();

        // Logika Upload Gambar
        if ($request->hasFile('image')) {
            // Simpan ke folder 'ingredients' di public disk
            $path = $request->file('image')->store('ingredients', 'public');
            $data['image'] = $path;
        }

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
        $request->validate([
            'name' => 'required|string|max:255|unique:ingredients,name,' . $ingredient->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($ingredient->image) {
                Storage::disk('public')->delete($ingredient->image);
            }
            // Upload gambar baru
            $path = $request->file('image')->store('ingredients', 'public');
            $data['image'] = $path;
        }

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
