<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

    /**
     * Reglas de validación compartidas entre store y update.
     * $sala es opcional: si viene, se ignora su ID en la regla unique del nombre.
     */
    protected function rules(?Sala $sala = null): array
    {
        return [
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('salas', 'nombre')->ignore($sala?->id),
            ],
            'capacidad' => ['required', 'integer', 'min:1'], // > 0
            'inhabilitado' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * Mensajes personalizados para usabilidad.
     */
    protected function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la sala es obligatorio.',
            'nombre.string'   => 'El nombre debe ser un texto válido.',
            'nombre.max'      => 'El nombre no puede superar 100 caracteres.',
            'nombre.unique'   => 'Ya existe una sala con ese nombre.',

            'capacidad.required' => 'La capacidad es obligatoria.',
            'capacidad.integer'  => 'La capacidad debe ser un número entero.',
            'capacidad.min'      => 'La capacidad debe ser mayor que 0.',

            'inhabilitado.boolean' => 'El valor de inhabilitado debe ser verdadero o falso.',
        ];
    }

    // Guardar nueva sala
    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages());

        // Importante: usar solo los datos validados
        Sala::create($data);

        return redirect()
            ->route('salas.index')
            ->with('success', '¡Sala creada!');
    }

    // Mostrar formulario de edición
    public function edit(Sala $sala)
    {
        return view('salas.form', compact('sala'));
    }

    // Actualizar sala
    public function update(Request $request, Sala $sala)
    {
        $data = $request->validate($this->rules($sala), $this->messages());

        $sala->update($data);

        return redirect()
            ->route('salas.index')
            ->with('success', 'Sala actualizada');
    }

    // Eliminar sala
    public function destroy(Sala $sala)
    {
        $sala->delete();
        return redirect()
            ->route('salas.index')
            ->with('success', 'Sala eliminada');
    }
}
