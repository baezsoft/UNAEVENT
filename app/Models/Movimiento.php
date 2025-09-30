<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Movimiento extends Model
{
    protected $table = 'movimientos';

    protected $fillable = [
        'id_evento',
        'id_acreditado',
        'tipo',
        'monto',
        'descripcion',
        'fecha',
        'inhabilitado',
    ];

    protected $casts = [
        'fecha' => 'datetime',
        'inhabilitado' => 'boolean',
        'monto' => 'decimal:2',
    ];

    // Relaciones
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento');
    }

    public function acreditado()
    {
        return $this->belongsTo(Acreditado::class, 'id_acreditado');
    }

    // Crear movimiento
    public static function crearMovimiento(array $data): self
    {
        if (empty($data['fecha'])) {
            $data['fecha'] = Carbon::now();
        }

        return self::create($data);
    }

    // Obtener movimientos con filtros
    public static function obtenerMovimientos(array $filtros = [])
    {
        $q = self::query()
            ->where('inhabilitado', false)
            ->with(['evento', 'acreditado']);

        if (!empty($filtros['tipo'])) {
            $q->where('tipo', $filtros['tipo']);
        }

        if (!empty($filtros['id_evento'])) {
            $q->where('id_evento', $filtros['id_evento']);
        }

        if (!empty($filtros['id_acreditado'])) {
            $q->where('id_acreditado', $filtros['id_acreditado']);
        }

        if (!empty($filtros['fecha_desde'])) {
            $q->where('fecha', '>=', Carbon::parse($filtros['fecha_desde'])->startOfDay());
        }

        if (!empty($filtros['fecha_hasta'])) {
            $q->where('fecha', '<=', Carbon::parse($filtros['fecha_hasta'])->endOfDay());
        }

        return $q->orderBy('fecha', 'desc');
    }

    // Inhabilitar movimiento
    public static function inhabilitarMovimiento(int $id): bool
    {
        $mov = self::find($id);
        if (!$mov) return false;

        $mov->inhabilitado = true;
        return $mov->save();
    }
}
