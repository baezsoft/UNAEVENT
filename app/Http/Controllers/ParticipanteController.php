<?php

namespace App\Http\Controllers;

use App\Models\Participante;
use Illuminate\Http\Request;

class ParticipanteController extends Controller
{
    /**
     * Marcar asistencia de un participante
     * GET /participantes/{id_acreditado}/{id_actividad}
     */
    public function marcarAsistencia($id_acreditado, $id_actividad)
    {
        // Buscar participante
        $participante = Participante::where('id_acreditado', $id_acreditado)
            ->where('id_actividad', $id_actividad)
            ->first();

        if (!$participante) {
            return response()->json([
                'success' => false,
                'message' => 'Participante no encontrado'
            ], 404);
        }

        // Actualizar asistencia
        $participante->update(['asistencia' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Asistencia marcada',
            'participante' => $participante
        ]);
    }
}
