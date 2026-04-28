<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('animales', function (Blueprint $table) {
        $table->id('id_animal');
        $table->foreignId('usuarios_id')->constrained('usuarios');
        $table->string('nombre', 50);
        $table->string('identificacion_propia', 30)->nullable();
        $table->string('especie', 30);
        $table->string('raza', 30)->nullable();
        $table->string('edad', 20)->nullable();
        $table->decimal('peso', 10, 2)->nullable();
        $table->string('estado_salud', 20)->nullable();
        $table->string('foto_url', 200)->nullable();
        $table->date('fecha_registro')->nullable();
        $table->char('sincronizado', 1)->default('N');
    });
    }
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
