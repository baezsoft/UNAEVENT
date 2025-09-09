<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->String('nombre', 150);
            $table->foreignId('id_usuario')
                  ->constrained('usuarios')
                  ->cascadeOnDelete();
            $table->foreignId('id_disertante')
                  ->nullable()
                  ->constrained('disertantes')
                  ->nullOnDelete();
            $table->foreignId('id_sala')
                  ->nullable()
                  ->constrained('salas')
                  ->nullOnDelete();
            $table->foreignId('id_disciplina')
                  ->nullable()
                  ->constrained('disciplinas')
                  ->nullOnDelete();
            $table->foreignId('id_evento')
                  ->nullable()
                  ->constrained('eventos')
                  ->nullOnDelete();
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->boolean('inhabilitado')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('actividades');
    }
};
