<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_acreditado')
                  ->constrained('acreditados')
                  ->onDelete('cascade');
            $table->foreignId('id_actividad')
                  ->constrained('actividades')
                  ->onDelete('cascade');
            $table->boolean('asistencia')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participantes');
    }
};
