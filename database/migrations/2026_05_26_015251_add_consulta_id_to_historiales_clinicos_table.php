<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('historiales_clinicos', function (Blueprint $table) {
            // Agregar columna consulta_id si no existe
            if (!Schema::hasColumn('historiales_clinicos', 'consulta_id')) {
                $table->unsignedBigInteger('consulta_id')->nullable()->after('id_historial');
                $table->foreign('consulta_id')->references('id_consulta')->on('consultas')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historiales_clinicos', function (Blueprint $table) {
            // Eliminar la relación foránea
            if (Schema::hasColumn('historiales_clinicos', 'consulta_id')) {
                $table->dropForeign(['consulta_id']);
                $table->dropColumn('consulta_id');
            }
        });
    }
};