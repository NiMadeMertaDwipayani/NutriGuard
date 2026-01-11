<?php

namespace App\Http\Controllers;

use App\Models\MealLog;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MealLogController extends Controller
{
    // Menampilkan Halaman Tracker
    public function index()
    {
        // Ambil data makan HARI INI saja
        $todayMeals = MealLog::where('user_id', Auth::id())
            ->whereDate('consumed_at', Carbon::today())
            ->with('ingredient') // Load relasi biar nama makanannya muncul
            ->get();

        // Hitung Total Kalori Hari Ini (Logic Sederhana)
        $totalCaloriesToday = $todayMeals->sum('total_calories');
        
        // Ambil daftar bahan makanan untuk Dropdown input
        $ingredients = Ingredient::all();

        return view('meals.index', compact('todayMeals', 'ingredients', 'totalCaloriesToday'));
    }

    // Proses Simpan & Hitung (LOGIKA KOMPLEKS DISINI)
    public function store(Request $request)
    {
        $request->validate([
            'ingredient_id' => 'required|exists:ingredients,id',
            'grams' => 'required|numeric|min:1',
            'consumed_at' => 'required|date',
        ]);

        // 1. Ambil Data Bahan Makanan (untuk tahu kalori per 100g)
        $ingredient = Ingredient::find($request->ingredient_id);

        // 2. RUMUS MATEMATIKA (Complex Logic)
        // Rumus: (Input Gram / 100) * Kalori Database
        $calculatedCalories = ($request->grams / 100) * $ingredient->calories;

        // 3. Cek Batas Harian (Warning System)
        $userLimit = Auth::user()->calorie_limit;
        $totalToday = MealLog::where('user_id', Auth::id())
                        ->whereDate('consumed_at', Carbon::parse($request->consumed_at))
                        ->sum('total_calories');
        
        $message = 'Makanan berhasil dicatat!';
        $alertType = 'success';

        // Logika Peringatan: Jika (Total Lama + Yang Baru) > Batas
        if (($totalToday + $calculatedCalories) > $userLimit) {
            $message = 'PERINGATAN: Asupan kalori Anda melebihi batas harian!';
            $alertType = 'warning'; // Nanti jadi warna kuning/merah
        }

        // 4. Simpan Hasil Hitungan
        MealLog::create([
            'user_id' => Auth::id(),
            'ingredient_id' => $request->ingredient_id,
            'grams' => $request->grams,
            'total_calories' => $calculatedCalories, // Simpan hasil hitungan, bukan input user
            'consumed_at' => $request->consumed_at,
        ]);

        return redirect()->route('meals.index')->with($alertType, $message);
    }
    
    // Hapus Log Makan
    public function destroy(MealLog $meal)
    {
        // Pastikan yang menghapus adalah pemilik data
        if ($meal->user_id !== Auth::id()) {
            abort(403);
        }
        
        $meal->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
