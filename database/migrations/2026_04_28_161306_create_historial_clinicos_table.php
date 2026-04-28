<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('historiales_clinicos', function (Blueprint $table) {
        $table->id('id_historial');
        $table->foreignId('usuarios_id')->constrained('usuarios');
        $table->foreignId('animales_id_animal')->constrained('animales', 'id_animal');
        $table->timestamp('fecha')->useCurrent();
        $table->string('tipo_evento', 30);
        $table->string('descripcion', 500)->nullable();
        $table->string('diagnostico', 200)->nullable();
        $table->string('tratamiento', 300)->nullable();
        $table->text('archivos_adjuntos')->nullable();
        $table->string('firma_digital', 100)->nullable();
        $table->char('sincronizado', 1)->default('N');
    });
    }
    public function down(): void
    {
        Schema::dropIfExists('historial_clinicos');
    }
};
