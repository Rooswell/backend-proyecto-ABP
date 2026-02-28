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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->string('cedula_usuario', 20)->primary();
            $table->string('nombre_usuario', 255);
            $table->string('email_usuario', 255)->unique();
            $table->string('contrasena', 255);
            $table->string('sexo', 20)->nullable();
            $table->string('numero_telefono_usuario', 30)->nullable();
            $table->string('estado', 30)->default('activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
