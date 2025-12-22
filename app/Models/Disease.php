<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; //tambahan

class Disease extends Model
{
    // Izinkan pengisian massal
    protected $fillable = ['name', 'description'];

    // RELASI MANY-TO-MANY
    // Satu Penyakit memiliki hubungan dengan Banyak Bahan Makanan
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)
                    ->withPivot('status') // membaca status (danger/safe)
                    ->withTimestamps();
    }        
}
