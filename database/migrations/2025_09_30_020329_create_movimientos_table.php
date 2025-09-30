<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();

            // FK a eventos y acreditados
            $table->foreignId('id_evento')->nullable()
                  ->constrained('eventos')
                  ->nullOnDelete();

            $table->foreignId('id_acreditado')->nullable()
                  ->constrained('acreditados')
                  ->nullOnDelete();

            $table->enum('tipo', ['entrada', 'salida']);
            $table->decimal('monto', 12, 2)->default(0);
            $table->text('descripcion')->nullable();
            $table->dateTime('fecha')->useCurrent();
            $table->boolean('inhabilitado')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
