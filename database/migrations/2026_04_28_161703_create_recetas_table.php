<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
    {
    Schema::create('recetas', function (Blueprint $table) {
        $table->id('id_receta');
        $table->foreignId('usuarios_id')->constrained('usuarios')->cascadeOnDelete();
        $table->foreignId('animales_id_animal')->constrained('animales', 'id_animal')->cascadeOnDelete();
        $table->foreignId('consultas_id_consulta')->constrained('consultas', 'id_consulta')->cascadeOnDelete();
        $table->timestamp('fecha_emision')->useCurrent();
        $table->date('fecha_vencimiento')->nullable();
        $table->string('firma_electronica', 100)->nullable();
        $table->string('estado', 15);
        $table->char('sincronizado', 1)->default('N');
    });
    }

    public function down(): void
    {
    Schema::dropIfExists('recetas');
    }
};
