<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('usuarios', function (Blueprint $table) {
        $table->id();
        $table->string('nombre_completo', 100);
        $table->string('documento', 20)->nullable();
        $table->string('telefono', 15)->nullable();
        $table->string('email', 80)->unique();
        $table->string('direccion', 150)->nullable();
        $table->string('rol', 20);
        $table->string('especialidad', 50)->nullable();
        $table->string('tarjeta_profesional', 30)->nullable();
        $table->char('estado', 1)->default('A');
        $table->string('registrado_por', 20)->nullable();
        $table->timestamp('timestamp_registro')->useCurrent();
        $table->string('password_hash', 200);
    });
    }
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
