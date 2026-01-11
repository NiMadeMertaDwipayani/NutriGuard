<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Disease;
use App\Models\Ingredient;
use App\Models\ActivityLog; // <--- TAMBAHAN PENTING 

class AdminController extends Controller
{
    public function dashboard()
    {
        // Hitung data untuk statistik di dashboard
        $totalUsers = User::where('role', 'user')->count();
        $totalDiseases = Disease::count();
        $totalIngredients = Ingredient::count();

        // --- 2. KODE BARU (Ambil Activity Log) ---
        // Ambil 10 aktivitas terakhir beserta data usernya
        $activities = ActivityLog::with('user')
                        ->latest()
                        ->take(10) 
                        ->get();

        // --- 3. Update Compact (Kirim $activities ke View) ---
        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalDiseases', 
            'totalIngredients', 
            'activities' // <--- Tambahkan ini
        ));
    }
}
