<?php

namespace App\Observers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Cek apakah yang buat Admin atau Register sendiri
        $actor = Auth::check() ? Auth::user()->name : 'Guest/Register';

        ActivityLog::create([
            'user_id' => Auth::id(), // Bisa null jika register baru
            'action' => 'Create User',
            'description' => "User baru terdaftar: {$user->name} ({$user->email})",
        ]);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Update User',
            'description' => "Mengupdate data user: {$user->name}",
        ]);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Delete User',
            'description' => "Menghapus user: {$user->name}",
        ]);
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
