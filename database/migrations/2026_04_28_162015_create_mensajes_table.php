<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('mensajes', function (Blueprint $table) {
        $table->id('id_mensaje');
        $table->foreignId('usuarios_id')->constrained('usuarios')->cascadeOnDelete();
        $table->foreignId('usuarios_id2')->constrained('usuarios')->cascadeOnDelete();
        $table->foreignId('consultas_id_consulta')->constrained('consultas', 'id_consulta')->cascadeOnDelete();
        $table->string('contenido', 2000);
        $table->string('tipo_contenido', 20)->nullable();
        $table->string('url_adjunto', 200)->nullable();
        $table->timestamp('fecha_envio')->useCurrent();
        $table->char('leido', 1)->default('N');
        $table->char('sincronizado', 1)->default('N');
    });
    }

    public function down(): void
    {
    Schema::dropIfExists('mensajes');
    }
};
