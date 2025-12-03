<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_path',
        'duration_minutes',
        'acupuncture_points', // Se guardará como JSON
        'materials',
        'description',
        'contraindications',
        'price',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     */
    protected $casts = [
        'acupuncture_points' => 'array', // ¡Crucial para los Tags!
        'price' => 'decimal:2',
    ];
}