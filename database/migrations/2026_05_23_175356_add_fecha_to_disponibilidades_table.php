<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disponibilidades', function (Blueprint $table) {
            $table->date('fecha')->nullable()->after('dia_semana')->comment('Fecha específica de la disponibilidad');
        });
    }

    public function down(): void
    {
        Schema::table('disponibilidades', function (Blueprint $table) {
            $table->dropColumn('fecha');
        });
    }
};