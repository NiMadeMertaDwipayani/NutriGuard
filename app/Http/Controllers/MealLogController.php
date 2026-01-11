<?php

namespace App\Http\Controllers;

use App\Models\MealLog;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // <--- PENTING

class MealLogController extends Controller
{
    // Menampilkan Halaman Tracker
    public function index()
    {

        $userId = Auth::id(); //tambahan baru

        // --- 1. Ambil data makan HARI INI saja
        $todayMeals = MealLog::where('user_id', Auth::id())
            ->whereDate('consumed_at', Carbon::today())
            ->with('ingredient') // Load relasi biar nama makanannya muncul
            ->get();

        // Hitung Total Kalori Hari Ini (Logic Sederhana)
        $totalCaloriesToday = $todayMeals->sum('total_calories');
        
        // Ambil daftar bahan makanan untuk Dropdown input
        $ingredients = Ingredient::all();

        // --- 2. DATA BARU: Total Nutrisi Hari Ini (Untuk Pie Chart) ---
        $totalProtein = 0;
        $totalCarbs = 0;
        $totalFat = 0;

        foreach ($todayMeals as $meal) {
            // Rumus: (Gram / 100) * Nutrisi per 100g
            if($meal->ingredient) { // Cek biar gak error kalau bahan dihapus
                $totalProtein += ($meal->grams / 100) * $meal->ingredient->protein;
                $totalCarbs   += ($meal->grams / 100) * $meal->ingredient->carbs;
                $totalFat     += ($meal->grams / 100) * $meal->ingredient->fat;
            }
        }

        // --- 3. DATA BARU: History 7 Hari Terakhir (Untuk Bar Chart) ---
        $historyData = MealLog::select(
                DB::raw('DATE(consumed_at) as date'), 
                DB::raw('SUM(total_calories) as total_cal')
            )
            ->where('user_id', $userId)
            ->where('consumed_at', '>=', Carbon::now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Siapkan Array untuk ChartJS (Isi 0 jika tanggal tidak ada data)
        $chartLabels = [];
        $chartValues = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $dateObj = Carbon::now()->subDays($i);
            $dateString = $dateObj->format('Y-m-d');
            
            $chartLabels[] = $dateObj->format('d M'); // Label: "12 Jan"
            
            // Cari data di tanggal ini
            $log = $historyData->firstWhere('date', $dateString);
            $chartValues[] = $log ? $log->total_cal : 0;
        }

        return view('meals.index', compact(
            'todayMeals', 
            'ingredients', 
            'totalCaloriesToday',
            'totalProtein', 'totalCarbs', 'totalFat', // Kirim data nutrisi
            'chartLabels', 'chartValues' // Kirim data grafik
        ));
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
