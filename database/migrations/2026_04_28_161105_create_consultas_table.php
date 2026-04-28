<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('consultas', function (Blueprint $table) {
        $table->id('id_consulta');
        $table->foreignId('usuarios_id')->constrained('usuarios');
        $table->foreignId('animales_id_animal')->constrained('animales', 'id_animal');
        $table->string('tipo_consulta', 20);
        $table->string('estado', 20);
        $table->timestamp('fecha_solicitud')->useCurrent();
        $table->timestamp('fecha_atencion')->nullable();
        $table->string('motivo', 300)->nullable();
        $table->string('urgencia', 15)->nullable();
        $table->string('diagnostico_resumido', 200)->nullable();
        $table->string('recomendaciones', 300)->nullable();
        $table->char('requiere_presencial', 1)->default('N');
        $table->integer('id_consulta_referencia')->nullable();
        $table->char('sincronizado', 1)->default('N');
    });
    }
    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
