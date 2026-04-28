<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('emergencias', function (Blueprint $table) {
        $table->id('id_emergencia');
        $table->foreignId('usuarios_id')->constrained('usuarios')->cascadeOnDelete();
        $table->foreignId('usuarios_id2')->constrained('usuarios')->cascadeOnDelete();
        $table->foreignId('animales_id_animal')->constrained('animales', 'id_animal')->cascadeOnDelete();
        $table->timestamp('fecha_reporte')->useCurrent();
        $table->string('sintomas_graves', 300)->nullable();
        $table->decimal('latitud', 10, 8)->nullable();
        $table->decimal('longitud', 11, 8)->nullable();
        $table->string('direccion_texto', 200)->nullable();
        $table->string('triage_resultado', 30)->nullable();
        $table->string('estado', 20);
        $table->char('sincronizado', 1)->default('N');
    });
    }

    public function down(): void
    {
    Schema::dropIfExists('emergencias');
    }
};
