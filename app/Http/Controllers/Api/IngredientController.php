<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IngredientController extends Controller
{
    // 1. GET (Ambil Semua Data)
    public function index()
    {
        $data = Ingredient::all();
        return response()->json([
            'status' => true,
            'message' => 'Data bahan makanan berhasil diambil',
            'data' => $data
        ], 200);
    }

    // 2. POST (Tambah Data Baru)
    public function store(Request $request)
    {
        // Validasi Input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'data' => $validator->errors()
            ], 422);
        }

        // Simpan ke Database
        $ingredient = Ingredient::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_safe' => true // Default aman (sesuaikan dengan kolom db anda)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Bahan makanan berhasil ditambahkan',
            'data' => $ingredient
        ], 201);
    }

    // 3. DELETE (Hapus Data)
    public function destroy($id)
    {
        $ingredient = Ingredient::find($id);

        if (!$ingredient) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $ingredient->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus',
            'data' => null
        ], 200);
    }
}
