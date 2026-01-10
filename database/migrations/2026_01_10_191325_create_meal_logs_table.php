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
        Schema::create('meal_logs', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users & ingredients
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ingredient_id')->constrained()->onDelete('cascade');

            // Inputan User
            $table->integer('grams'); // Berapa gram dimakan

            // Hasil Kalkulasi Sistem (Disimpan agar historis akurat meski data induk berubah)
            $table->float('total_calories'); 

            // Tanggal makan (untuk filter & grafik)
            $table->date('consumed_at');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_logs');
    }
};
