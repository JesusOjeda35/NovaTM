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
        Schema::table('consultas', function (Blueprint $table) {
            // Agregar columna historial_id después de disponibilidad_id
            $table->unsignedBigInteger('historial_id')->nullable()->after('disponibilidad_id');
            
            // Agregar foreign key a historiales_clinicos
            $table->foreign('historial_id')
                ->references('id_historial')
                ->on('historiales_clinicos')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->dropForeign(['historial_id']);
            $table->dropColumn('historial_id');
        });
    }
};