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
        Schema::table('ingredients', function (Blueprint $table) {
            // Menambah kolom nutrisi (Default 0 agar data lama tidak error)
            $table->integer('calories')->default(0)->after('name'); 
            $table->float('protein')->default(0)->after('calories');
            $table->float('carbs')->default(0)->after('protein');
            $table->float('fat')->default(0)->after('carbs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingredients', function (Blueprint $table) {
            //
        });
    }
};
