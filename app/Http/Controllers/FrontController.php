<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    // Fungsi Pencarian (API untuk AJAX)
    public function search(Request $request)
    {
        $query = $request->get('query');

        // 1. Cari Bahan Makanan berdasarkan nama
        $ingredients = Ingredient::where('name', 'like', "%{$query}%")->get();

        // Siapkan array hasil
        $results = [];

        foreach ($ingredients as $item) {
            // Default status (Jika user belum login atau tidak ada pantangan)
            $status = 'neutral'; 
            $message = 'Login untuk cek keamanan.';
            $conflictingDiseases = [];

            // 2. LOGIKA CEK KESEHATAN (Hanya jika User Login)
            if (Auth::check()) {
                $user = Auth::user();
                $status = 'safe'; // Asumsi awal: Aman
                $message = 'Aman dikonsumsi.';

                // Loop semua penyakit yang diderita User
                foreach ($user->diseases as $disease) {
                    // Cek apakah penyakit ini punya hubungan dengan bahan ini?
                    // Mengambil data dari tabel pivot (disease_ingredient)
                    $relation = $disease->ingredients()->where('ingredient_id', $item->id)->first();

                    if ($relation) {
                        $pivotStatus = $relation->pivot->status; // safe, warning, atau danger

                        // Logika Prioritas: DANGER mengalahkan WARNING, WARNING mengalahkan SAFE
                        if ($pivotStatus === 'danger') {
                            $status = 'danger';
                            $conflictingDiseases[] = $disease->name; // Catat penyakit penyebabnya
                        } elseif ($pivotStatus === 'warning' && $status !== 'danger') {
                            $status = 'warning';
                            $conflictingDiseases[] = $disease->name;
                        }
                    }
                }

                // Susun Pesan Kesimpulan
                if ($status === 'danger') {
                    $message = 'BAHAYA! Pantangan untuk: ' . implode(', ', array_unique($conflictingDiseases));
                } elseif ($status === 'warning') {
                    $message = 'BATASI. Peringatan untuk: ' . implode(', ', array_unique($conflictingDiseases));
                }
            }

            // Masukkan data ke hasil
            $results[] = [
                'id' => $item->id,
                'name' => $item->name,
                'image' => $item->image ? asset('storage/' . $item->image) : null,
                'status' => $status, // neutral, safe, warning, danger
                'message' => $message,
            ];
        }

        // Kembalikan sebagai JSON (Agar bisa dibaca Javascript di halaman depan)
        return response()->json($results);
    }
}
