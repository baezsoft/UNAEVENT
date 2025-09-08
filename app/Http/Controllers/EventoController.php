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
            'fecha' => 'required|date',
            'tarifa' => 'numeric|min:0',
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
            'fecha' => 'required|date',
            'tarifa' => 'numeric|min:0',
        ]);

        $evento->update($request->all());

        return redirect()->route('eventos.index')->with('success', 'Evento actualizado correctamente');
    }

    public function destroy(Evento $evento)
    {
        $evento->update(['inhabilitado' => true]);

        return redirect()->route('eventos.index')->with('success', 'Evento inhabilitado');
    }
}
