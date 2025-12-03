<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    // Estos son los campos de la CITA, no del procedimiento
    protected $fillable = [
        'patient_id',
        'scheduled_at',
        'status',
        'reason',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    /**
     * Relación: Una cita pertenece a un Paciente.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}