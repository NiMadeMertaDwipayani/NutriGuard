<?php

namespace App\Observers;

use App\Models\Disease;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class DiseaseObserver
{
    /**
     * Handle the Disease "created" event.
     */
    public function created(Disease $disease): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Create Disease',
            'description' => "Menambahkan data penyakit baru: {$disease->name}",
        ]);
    }

    /**
     * Handle the Disease "updated" event.
     */
    public function updated(Disease $disease): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Update Disease',
            'description' => "Mengupdate data penyakit: {$disease->name}",
        ]);
    }

    /**
     * Handle the Disease "deleted" event.
     */
    public function deleted(Disease $disease): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Delete Disease',
            'description' => "Menghapus data penyakit: {$disease->name}",
        ]);
    }

    /**
     * Handle the Disease "restored" event.
     */
    public function restored(Disease $disease): void
    {
        //
    }

    /**
     * Handle the Disease "force deleted" event.
     */
    public function forceDeleted(Disease $disease): void
    {
        //
    }
}
