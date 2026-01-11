<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\MealLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UasApiController extends Controller
{
    // 1. Endpoint Data Bahan (Termasuk Nutrisi)
    public function getIngredients()
    {
        $ingredients = Ingredient::all();
        
        return response()->json([
            'status' => 'success',
            'total_data' => $ingredients->count(),
            'data' => $ingredients
        ], 200);
    }

    // 2. Endpoint Laporan/Rekapitulasi (Syarat UAS Poin D)
    public function getReports(Request $request)
    {
        // Ambil User ID dari request (Simulasi: misal user_id = 1 atau dari token)
        // Untuk UAS sederhana, kita bisa ambil user pertama atau inputan param
        $userId = $request->query('user_id'); 

        if(!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Mohon sertakan parameter ?user_id=1'], 400);
        }

        // LOGIKA REKAPITULASI (Sama seperti Grafik Batang)
        // Menghitung total kalori per hari dalam 7 hari terakhir
        $historyData = MealLog::select(
                DB::raw('DATE(consumed_at) as date'), 
                DB::raw('SUM(total_calories) as total_cal')
            )
            ->where('user_id', $userId)
            ->where('consumed_at', '>=', Carbon::now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        return response()->json([
            'status' => 'success',
            'description' => 'Laporan total kalori 7 hari terakhir',
            'data' => $historyData
        ], 200);
    }
}