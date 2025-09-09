<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory;


    protected $fillable = [
        'nombre',
        'apellido',
        'direccion',
        'password',
        'correo',
        'tel',
        'estado',
        'ci',
        'cargo',
        'inhabilitado',
    ];

    protected $hidden = [
        'password',
    ];

    // Mutator para hashear la contraseña automáticamente
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function isAdmin()
    {
        return $this->cargo === 'admin';
    }
}
