<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acreditado extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_evento', 'fecha_acreditacion', 'estado', 'dni', 'nombre', 
        'apellido', 'fecha_nacimiento', 'genero', 'nacionalidad', 
        'telefono', 'correo', 'inhabilitado', 'token'
    ];

    protected $casts = [
        'genero' => 'boolean',
        'inhabilitado' => 'boolean',
        'fecha_nacimiento' => 'date',
        'fecha_acreditacion' => 'date'
    ];

    // Genera token único al crear
    protected static function booted()
    {
        static::creating(function ($acreditado) {
            $acreditado->token = bin2hex(random_bytes(16));
        });
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento');
    }
}
