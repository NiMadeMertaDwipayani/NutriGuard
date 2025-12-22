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
        Schema::create('disease_ingredient', function (Blueprint $table) {
            $table->id();
            // Kunci Asing (Foreign Keys)
            $table->foreignId('disease_id')->constrained()->onDelete('cascade');
            $table->foreignId('ingredient_id')->constrained()->onDelete('cascade');
            
            // Status Hubungan (PENTING!)
            // Apakah bahan ini BERBAHAYA atau AMAN untuk penyakit tersebut?
            // 'danger' = Pantangan Keras
            // 'warning' = Boleh sedikit (Dibatasi)
            // 'safe' = Direkomendasikan
            $table->enum('status', ['danger', 'warning', 'safe'])->default('danger');

            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disease_ingredient');
    }
};
