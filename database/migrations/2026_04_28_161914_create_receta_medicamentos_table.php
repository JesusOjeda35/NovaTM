<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('receta_medicamentos', function (Blueprint $table) {
        $table->id('id_detalle');
        $table->foreignId('recetas_id')->constrained('recetas', 'id_receta')->cascadeOnDelete();
        $table->string('nombre_medicamento', 100);
        $table->string('dosis', 50)->nullable();
        $table->string('via_administracion', 30)->nullable();
        $table->string('duracion', 50)->nullable();
        $table->string('instrucciones', 200)->nullable();
    });
    }

    public function down(): void
    {
    Schema::dropIfExists('receta_medicamentos');
    }
};
