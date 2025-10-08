<?php

namespace App\Support;

use App\Models\Movimiento;
use App\Models\Acreditado;
use App\Models\Actividad;
use Illuminate\Support\Facades\DB;

/**
 * Utilidad para generar la estructura de un Ticket de Movimiento.
 * Requisitos:
 * - Retorna array con claves: movimiento, acreditado (o null), actividades (array)
 * - Filtra registros inhabilitados
 * - Reutilizable en controladores, jobs, commands, etc.
 */
class TicketMovimiento
{
    /**
     * Genera un ticket para el movimiento indicado.
     *
     * Contract / Output shape:
     * [
     *   'movimiento' => [ 'id' => int, 'tipo' => string, 'monto' => float, 'descripcion' => string|null, 'fecha' => string ISO8601 ],
     *   'acreditado' => [ ... ] | null,
     *   'actividades' => [ [ ... ], ... ]
     * ]
     *
     * @param int $idMovimiento
     * @return array{movimiento:array, acreditado:?array, actividades:array}
     */
    public static function generar(int $idMovimiento): array
    {
        // Carga del movimiento validando que no esté inhabilitado
        /** @var Movimiento|null $mov */
        $mov = Movimiento::query()
            ->where('id', $idMovimiento)
            ->where('inhabilitado', false)
            ->first();

        if (!$mov) {
            return [
                'movimiento' => null,
                'acreditado' => null,
                'actividades' => [],
                'error' => 'Movimiento no encontrado o inhabilitado'
            ];
        }

        $movimiento = [
            'id' => $mov->id,
            'tipo' => $mov->tipo,
            'monto' => (float) $mov->monto,
            'descripcion' => $mov->descripcion,
            'fecha' => optional($mov->fecha)->toIso8601String(),
        ];

        $acreditadoData = null;
        $actividades = [];

        if ($mov->id_acreditado) {
            /** @var Acreditado|null $acreditado */
            $acreditado = Acreditado::query()
                ->where('id', $mov->id_acreditado)
                ->where('inhabilitado', false)
                ->first();

            if ($acreditado) {
                $acreditadoData = [
                    'id' => $acreditado->id,
                    'dni' => $acreditado->dni,
                    'nombre' => $acreditado->nombre,
                    'apellido' => $acreditado->apellido,
                    'correo' => $acreditado->correo,
                    'telefono' => $acreditado->telefono,
                    'estado' => $acreditado->estado,
                    'fecha_acreditacion' => optional($acreditado->fecha_acreditacion)->toDateString(),
                ];

                // Obtener actividades vinculadas con joins (evita N+1)
                $actividades = DB::table('actividades')
                    ->select('actividades.id', 'actividades.nombre', 'actividades.fecha', 'actividades.hora_inicio', 'actividades.hora_fin')
                    ->join('participantes', 'participantes.id_actividad', '=', 'actividades.id')
                    ->where('participantes.id_acreditado', $acreditado->id)
                    ->where('actividades.inhabilitado', false)
                    ->get()
                    ->map(function ($row) {
                        return [
                            'id' => $row->id,
                            'nombre' => $row->nombre,
                            'fecha' => $row->fecha,
                            'hora_inicio' => $row->hora_inicio,
                            'hora_fin' => $row->hora_fin,
                        ];
                    })
                    ->values()
                    ->toArray();
            }
        }

        return [
            'movimiento' => $movimiento,
            'acreditado' => $acreditadoData,
            'actividades' => $actividades,
        ];
    }
}
