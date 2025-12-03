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
    Schema::create('procedures', function (Blueprint $table) {
        $table->id();
        $table->string('name'); 
        $table->string('image_path')->nullable(); // Imagen opcional
        $table->integer('duration_minutes'); // Tiempo estimado
        $table->json('acupuncture_points'); // Tags de puntos
        $table->text('materials'); // Materiales
        $table->longText('description'); // RichEditor va aquí
        $table->text('contraindications')->nullable(); // Alerta opcional
        $table->decimal('price', 10, 2); // Precio (Agregado por el checklist de Trello)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedures');
    }
};
