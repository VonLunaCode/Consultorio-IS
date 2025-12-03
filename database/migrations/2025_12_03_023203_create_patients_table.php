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
    Schema::create('patients', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Nombre Completo
        $table->string('email')->unique()->nullable();
        $table->date('birth_date'); // Fecha de Nacimiento (Edad se calcula)
        $table->enum('gender', ['M', 'F', 'O']); // Sexo/Género
        $table->string('phone'); // Teléfono
        $table->string('curp')->nullable(); // Opcional
        $table->text('address'); // Domicilio
        $table->json('allergies'); // Tags de alergias
        $table->text('chronic_diseases')->nullable(); // Opcional
        $table->string('emergency_contact'); // Contacto emergencia
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
