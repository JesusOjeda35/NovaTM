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
            $table->unsignedBigInteger('Users_id');
            $table->unsignedBigInteger('Users_id2')->nullable();
            $table->unsignedBigInteger('consultas_id_consulta')->nullable();
            $table->longText('contenido');
            $table->string('tipo_contenido')->nullable();
            $table->string('url_adjunto')->nullable();
            $table->dateTime('fecha_envio')->nullable();
            $table->char('leido', 1)->default('N');
            $table->char('sincronizado', 1)->default('N');
            $table->boolean('eliminado_por_emisor')->default(false);
            $table->boolean('eliminado_por_receptor')->default(false);

            // Claves foráneas
            $table->foreign('Users_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('Users_id2')->references('id')->on('users')->onDelete('set null');
            $table->foreign('consultas_id_consulta')->references('id_consulta')->on('consultas')->onDelete('set null');

            // Índices
            $table->index('Users_id');
            $table->index('Users_id2');
            $table->index('consultas_id_consulta');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensajes');
    }
};