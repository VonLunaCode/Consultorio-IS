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
    Schema::create('appointments', function (Blueprint $table) {
        $table->id();
        // Relación con Paciente
        $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
        $table->dateTime('scheduled_at'); // Fecha y Hora
        // Estatus con valor por defecto
        $table->enum('status', ['pendiente', 'confirmada', 'cancelada', 'finalizada'])->default('pendiente');
        $table->text('reason'); // Motivo consulta
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
