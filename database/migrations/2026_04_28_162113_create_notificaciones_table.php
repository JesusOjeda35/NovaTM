<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('notificaciones', function (Blueprint $table) {
        $table->id('id_notificacion');
        $table->foreignId('usuarios_id')->constrained('usuarios')->cascadeOnDelete();
        $table->string('tipo', 30);
        $table->string('contenido', 300);
        $table->char('leido', 1)->default('N');
        $table->timestamp('fecha_creacion')->useCurrent();
        $table->char('sincronizado', 1)->default('N');
    });
    }

    public function down(): void
    {
    Schema::dropIfExists('notificaciones');
    }
};
