<?php

namespace App\Observers;

use App\Models\Ingredient;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class IngredientObserver
{
    // Jalan otomatis saat DATA BARU dibuat
    public function created(Ingredient $ingredient): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(), // Siapa pelakunya (Admin)
            'action' => 'Create Ingredient',
            'description' => "Menambahkan bahan makanan baru: {$ingredient->name}",
        ]);
    }

    // Jalan otomatis saat DATA DIUPDATE
    public function updated(Ingredient $ingredient): void
    {
        // Cek apa saja yang berubah (Fitur Logika Kompleks)
        $changes = [];
        if ($ingredient->isDirty('calories')) {
            $changes[] = "Kalori berubah dari {$ingredient->getOriginal('calories')} ke {$ingredient->calories}";
        }
        
        // Simpan log hanya jika ada perubahan
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Update Ingredient',
            'description' => "Mengupdate {$ingredient->name}. Detail: " . implode(', ', $changes),
        ]);
    }

    // Jalan otomatis saat DATA DIHAPUS
    public function deleted(Ingredient $ingredient): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Delete Ingredient',
            'description' => "Menghapus bahan makanan: {$ingredient->name}",
        ]);
    }

    /**
     * Handle the Ingredient "restored" event.
     */
    public function restored(Ingredient $ingredient): void
    {
        //
    }

    /**
     * Handle the Ingredient "force deleted" event.
     */
    public function forceDeleted(Ingredient $ingredient): void
    {
        //
    }
}
