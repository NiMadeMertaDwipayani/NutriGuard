<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            // User yang melakukan aksi (Nullable: jika user dihapus, log tetap ada)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            $table->string('action'); // Contoh: "Create", "Update", "Delete"
            $table->text('description'); // Contoh: "Mengubah harga bayam..."

            $table->timestamps(); // Mencatat waktu kejadian otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
