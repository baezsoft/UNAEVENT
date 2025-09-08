<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Evento extends Model
{
    protected $table = 'eventos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha',
        'lugar',
        'tarifa',
        'inhabilitado',
    ];

    protected $casts = [
        'fecha' => 'date',
        'inhabilitado' => 'boolean',
        'tarifa' => 'decimal:2',
    ];
}
