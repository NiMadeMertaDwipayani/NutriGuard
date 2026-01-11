<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealLog extends Model
{
    use HasFactory;

    // IZINKAN KOLOM INI DIISI OTOMATIS
    protected $fillable = [
        'user_id',
        'ingredient_id',
        'grams',
        'total_calories',
        'consumed_at',
    ];

    // Relasi ke Ingredient (Agar bisa panggil $log->ingredient->name)
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
