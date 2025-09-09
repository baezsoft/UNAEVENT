<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Actividad extends Model
{
    use HasFactory;

    protected $table = 'actividades';

    protected $fillable = [
        'nombre',
        'id_usuario',
        'id_disertante',
        'id_sala',
        'id_disciplina',
        'id_evento',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'inhabilitado',
    ];

    // Relaciones
    public function usuario() {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function disertante() {
        return $this->belongsTo(Disertante::class, 'id_disertante');
    }

    public function sala() {
        return $this->belongsTo(Sala::class, 'id_sala');
    }

    public function disciplina() {
        return $this->belongsTo(Disciplina::class, 'id_disciplina');
    }

    public function evento() {
        return $this->belongsTo(Evento::class, 'id_evento');
    }
}
