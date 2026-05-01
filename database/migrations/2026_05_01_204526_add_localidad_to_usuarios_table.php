<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Agregar columnas de localidad después de 'direccion'
            $table->foreignId('pais_id')->nullable()->after('direccion')->constrained('paises')->onDelete('set null');
            $table->foreignId('departamento_id')->nullable()->after('pais_id')->constrained('departamentos')->onDelete('set null');
            $table->foreignId('municipio_id')->nullable()->after('departamento_id')->constrained('municipios')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropConstrainedForeignId('pais_id');
            $table->dropConstrainedForeignId('departamento_id');
            $table->dropConstrainedForeignId('municipio_id');
        });
    }
};