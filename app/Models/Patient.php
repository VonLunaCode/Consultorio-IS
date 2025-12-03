<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'birth_date',
        'gender',
        'phone',
        'curp',
        'address',
        'allergies',        // Se guardará como JSON
        'chronic_diseases',
        'emergency_contact',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     */
    protected $casts = [
        'birth_date' => 'date',
        'allergies' => 'array', // ¡Crucial para que funcionen los Tags de Filament!
    ];

    /**
     * Relación: Un paciente tiene muchas citas.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}