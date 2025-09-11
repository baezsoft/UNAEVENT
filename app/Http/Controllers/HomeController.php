<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Evento;
use App\Models\Acreditado;
use App\Models\Disertante;
use App\Models\Actividad;
use App\Models\Sala;
use App\Models\Participante;

class HomeController extends Controller
{
    public function index()
    {
        // Si no está logueado → mostrar landing
        if (!Auth::check()) {
            $evento = Evento::orderBy('fecha', 'asc')->first(); // evento más próximo
            return view('landing', compact('evento'));
        }

        // Si está logueado → mostrar dashboard
        return view('dashboard.index', [
            'totalEventos' => Evento::count(),
            'eventosProximos' => Evento::where('fecha', '>=', now())->count(),
            'eventosFinalizados' => Evento::where('fecha', '<', now())->count(),

            'totalAcreditados' => Acreditado::count(),
            'acreditadosActivos' => Acreditado::where('inhabilitado', false)->count(),
            'acreditadosInhabilitados' => Acreditado::where('inhabilitado', true)->count(),

            'totalDisertantes' => Disertante::count(),

            'totalActividades' => Actividad::count(),
            'actividadesHoy' => Actividad::where('fecha', now()->toDateString())->count(),

            'totalSalas' => Sala::count(),

            'totalParticipantes' => Participante::count(),
            'participantesConAsistencia' => Participante::where('asistencia', true)->count(),
        ]);
    }
}
