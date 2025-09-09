<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Usuario;
use App\Models\Disertante;
use App\Models\Sala;
use App\Models\Disciplina;
use App\Models\Evento;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    public function index(Request $request)
    {
        $query = Actividad::with(['usuario', 'disertante', 'sala', 'disciplina', 'evento']);

        // Filtros
        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }
        if ($request->filled('evento')) {
            $query->where('id_evento', $request->evento);
        }
        if ($request->filled('sala')) {
            $query->where('id_sala', $request->sala);
        }

        $actividades = $query->paginate(10)->appends($request->query());

        return view('actividades.index', compact('actividades'));
    }

    public function create()
    {
        return view('actividades.create', [
            'usuarios' => Usuario::all(),
            'disertantes' => Disertante::all(),
            'salas' => Sala::all(),
            'disciplinas' => Disciplina::all(),
            'eventos' => Evento::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id',
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'hora_fin' => 'required|after:hora_inicio',
        ]);

        Actividad::create($request->all());

        return redirect()->route('actividades.index')->with('success', 'Actividad creada correctamente.');
    }

    public function edit(Actividad $actividad)
    {
        return view('actividades.edit', [
            'actividad' => $actividad,
            'usuarios' => Usuario::all(),
            'disertantes' => Disertante::all(),
            'salas' => Sala::all(),
            'disciplinas' => Disciplina::all(),
            'eventos' => Evento::all(),
        ]);
    }

    public function update(Request $request, Actividad $actividad)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id',
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'hora_fin' => 'required|after:hora_inicio',
        ]);

        $actividad->update($request->all());

        return redirect()->route('actividades.index')->with('success', 'Actividad actualizada correctamente.');
    }

    public function destroy(Actividad $actividad)
    {
        $actividad->delete();

        return redirect()->route('actividades.index')->with('success', 'Actividad eliminada.');
    }
}
