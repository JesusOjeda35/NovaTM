<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('configuracion', function (Blueprint $table) {
        $table->id('id_config');
        $table->foreignId('usuarios_id')->constrained('usuarios')->cascadeOnDelete();
        $table->string('clave', 50);
        $table->string('valor', 200)->nullable();
        $table->timestamp('actualizado')->useCurrent()->useCurrentOnUpdate();
    });
    }

    public function down(): void
    {
    Schema::dropIfExists('configuracion');
    }
};
