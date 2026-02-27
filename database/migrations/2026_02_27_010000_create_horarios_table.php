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
        Schema::dropIfExists('horarios');
        
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('dia_semana');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->string('estado')->default('activo');
            $table->string('usuario_id')->nullable();
            $table->date('fecha')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('horarios')) {
            Schema::dropIfExists('horarios');
        }
    }
};
