<?php

namespace App\Http\Controllers;

use App\Models\Disertante;
use Illuminate\Http\Request;

class DisertanteController extends Controller
{
    public function index(Request $request)
    {
        $query = Disertante::query();
    
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('apellido', 'LIKE', "%{$search}%")
                  ->orWhere('especialidad', 'LIKE', "%{$search}%");
            });
        }
    
        $disertantes = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
    
        return view('disertantes.index', compact('disertantes'));
    }
    
    public function create()
    {
        return view('disertantes.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:100',
            'apellido'     => 'required|string|max:100',
            'correo'       => 'required|email|unique:disertantes,correo',
            'telefono'     => 'nullable|string|max:30',
            'institucion'  => 'nullable|string|max:150',
            'especialidad' => 'nullable|string|max:100',
            'cv'           => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);
    
        $data = $request->all();
    
        if ($request->hasFile('cv')) {
            $data['cv'] = $request->file('cv')->store('cv_disertantes', 'public');
        }
    
        Disertante::create($data);
    
        return redirect()->route('disertantes.index')->with('success', 'Disertante creado correctamente.');
    }
    
    public function update(Request $request, Disertante $disertante)
    {
        $request->validate([
            'nombre'       => 'required|string|max:100',
            'apellido'     => 'required|string|max:100',
            'correo'       => 'required|email|unique:disertantes,correo,' . $disertante->id,
            'telefono'     => 'nullable|string|max:30',
            'institucion'  => 'nullable|string|max:150',
            'especialidad' => 'nullable|string|max:100',
            'cv'           => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);
    
        $data = $request->all();
    
        if ($request->hasFile('cv')) {
            // borrar el CV anterior si existe
            if ($disertante->cv && \Storage::disk('public')->exists($disertante->cv)) {
                \Storage::disk('public')->delete($disertante->cv);
            }
            $data['cv'] = $request->file('cv')->store('cv_disertantes', 'public');
        }
    
        $disertante->update($data);
    
        return redirect()->route('disertantes.index')->with('success', 'Disertante actualizado correctamente.');
    }
    
    public function show(Disertante $disertante)
    {
        return view('disertantes.show', compact('disertante'));
    }

    public function edit(Disertante $disertante)
    {
        return view('disertantes.edit', compact('disertante'));
    }


    public function destroy(Disertante $disertante)
    {
        $disertante->delete();
        return redirect()->route('disertantes.index')->with('success', 'Disertante eliminado correctamente.');
    }
}
