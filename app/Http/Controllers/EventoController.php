<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::where('inhabilitado', false)
            ->orderBy('fecha', 'desc')
            ->paginate(10);

        return view('eventos.index', compact('eventos'));
    }

    public function create()
    {
        return view('eventos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'fecha' => 'required|date|after_or_equal:today',
            'lugar' => 'nullable|string|max:200',
            'tarifa' => 'nullable|numeric|min:0',
            'inhabilitado' => 'boolean',
        ]);

        Evento::create($request->all());

        return redirect()->route('eventos.index')->with('success', 'Evento creado correctamente');
    }

    public function show(Evento $evento)
    {
        return view('eventos.show', compact('evento'));
    }

    public function edit(Evento $evento)
    {
        return view('eventos.edit', compact('evento'));
    }

    public function update(Request $request, Evento $evento)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'fecha' => 'required|date|after_or_equal:today',
            'lugar' => 'nullable|string|max:200',
            'tarifa' => 'nullable|numeric|min:0',
            'inhabilitado' => 'boolean',
        ]);

        $evento->update($request->all());

        return redirect()->route('eventos.index')->with('success', 'Evento actualizado correctamente');
    }

    public function destroy(Evento $evento)
    {
        $evento->update(['inhabilitado' => true]);

        return redirect()->route('eventos.index')->with('success', 'Evento inhabilitado');
    }

    public function actividades($eventoId)
    {
        // Validar que exista el evento
        $evento = \App\Models\Evento::findOrFail($eventoId);
    
        // Obtener actividades vinculadas
        $actividades = \App\Models\Actividad::where('id_evento', $eventoId)
            ->get(['id', 'nombre']);
    
        return response()->json($actividades);
    }
}
