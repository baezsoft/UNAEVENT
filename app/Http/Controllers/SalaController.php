<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use Illuminate\Http\Request;

class SalaController extends Controller
{
    // Mostrar todas las salas
    public function index()
    {
        $salas = Sala::all();
        return view('salas.index', compact('salas'));
    }

    // Mostrar formulario para crear sala
    public function create()
    {
        return view('salas.form');
    }

    // Guardar nueva sala
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'capacidad' => 'required|integer|min:1',
        ]);

        Sala::create($request->all());
        return redirect()->route('salas.index')->with('success', 'Sala creada! ');
    }

    // Mostrar formulario de edición
    public function edit(Sala $sala)
    {
        return view('salas.form', compact('sala'));
    }

    // Actualizar sala
    public function update(Request $request, Sala $sala)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'capacidad' => 'required|integer|min:1',
            'inhabilitado' => 'boolean',
        ]);

        $sala->update($request->all());
        return redirect()->route('salas.index')->with('success', 'Sala actualizada');
    }

    // Eliminar sala (opcional si quieres soft delete)
    public function destroy(Sala $sala)
    {
        $sala->delete();
        return redirect()->route('salas.index')->with('success', 'Sala eliminada');
    }
}
