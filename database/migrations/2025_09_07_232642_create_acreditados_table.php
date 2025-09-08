<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcreditadosTable extends Migration
{
    public function up(): void
    {
        Schema::create('acreditados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_evento')->constrained('eventos')->cascadeOnDelete();
            $table->date('fecha_acreditacion');
            $table->string('estado', 20)->default('pendiente');
            $table->string('dni', 20)->unique();
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->date('fecha_nacimiento')->nullable();
            $table->boolean('genero')->nullable();
            $table->string('nacionalidad', 100)->nullable();
            $table->string('telefono', 30)->nullable();
            $table->string('correo', 150)->nullable();
            $table->boolean('inhabilitado')->default(false);
            $table->string('token', 100)->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acreditados');
    }
}
