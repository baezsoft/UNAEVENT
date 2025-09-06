<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id(); // id serial / bigint
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('direccion', 200)->nullable();
            $table->string('password'); // se hash automáticamente en el modelo
            $table->string('correo', 150)->unique();
            $table->string('tel', 30)->nullable();
            $table->string('estado', 20)->nullable();
            $table->string('ci', 20)->unique()->nullable();
            $table->string('cargo', 50)->nullable();
            $table->boolean('inhabilitado')->default(false);
            $table->timestamps(); // created_at y updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
