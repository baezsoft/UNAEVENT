<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disertante extends Model
{
    use HasFactory;

    protected $table = 'disertantes';

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'telefono',
        'institucion',
        'cv',
        'especialidad',
        'inhabilitado'
    ];

    protected $casts = [
        'inhabilitado' => 'boolean',
    ];
}
