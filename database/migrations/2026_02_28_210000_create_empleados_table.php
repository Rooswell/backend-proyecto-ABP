<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->string('cedula_usuario', 10)->primary();
            $table->string('rol', 20)->default('EMPLEADO');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
