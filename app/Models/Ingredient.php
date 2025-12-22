<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ingredient extends Model
{
    protected $fillable = ['name', 'image'];

    // RELASI MANY-TO-MANY
    // Satu Bahan Makanan bisa jadi pantangan untuk Banyak Penyakit
    public function diseases()
    {
        return $this->belongsToMany(Disease::class)
                    ->withPivot('status') // Penting!
                    ->withTimestamps();
    }                
}
