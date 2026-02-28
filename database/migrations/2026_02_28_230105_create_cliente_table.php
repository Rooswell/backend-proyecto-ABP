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
        Schema::create('cliente', function (Blueprint $table) {
            $table->string('cedula_cliente', 10)->primary();
            $table->string('nombre_cliente', 100);
            $table->string('email_cliente', 100)->nullable();
            $table->string('sexo_cliente', 1)->nullable();
            $table->string('direccion_cliente', 150)->nullable();
            $table->string('numero_telefono_cliente', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente');
    }
};
