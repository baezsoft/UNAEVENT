<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('disertantes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('correo', 150)->unique();
            $table->string('telefono', 30)->nullable();
            $table->string('institucion', 150)->nullable();
            $table->string('cv')->nullable(); // ruta del archivo
            $table->string('especialidad', 100)->nullable();
            $table->boolean('inhabilitado')->default(false);
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void {
        Schema::dropIfExists('disertantes');
    }
};
