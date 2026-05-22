<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disponibilidades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('especialidad', 50)->nullable(); // Especialidad del profesional
            $table->string('dia_semana', 20); // Lunes, Martes, Miércoles, etc.
            $table->time('hora_inicio'); // Hora de inicio
            $table->time('hora_fin'); // Hora de fin
            $table->decimal('precio_consulta', 10, 2); // Precio de la consulta
            $table->boolean('activo')->default(true); // Si está disponible o no
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disponibilidades');
    }
};