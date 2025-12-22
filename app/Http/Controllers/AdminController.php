<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Disease;
use App\Models\Ingredient;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Hitung data untuk statistik di dashboard
        $totalUsers = User::where('role', 'user')->count();
        $totalDiseases = Disease::count();
        $totalIngredients = Ingredient::count();

        return view('admin.dashboard', compact('totalUsers', 'totalDiseases', 'totalIngredients'));
    }
}
