<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    use HasFactory;

    protected $fillable = ['id_acreditado', 'id_actividad', 'asistencia'];

    public function acreditado()
    {
        return $this->belongsTo(Acreditado::class, 'id_acreditado');
    }

    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'id_actividad');
    }
}
