<?php

namespace App\Http\Controllers;

use App\Models\Disciplina;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DisciplinaController extends Controller
{
    public function index(Request $request)
    {
        $query = Disciplina::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nombre', 'LIKE', "%{$search}%");
        }

        $disciplinas = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('disciplinas.index', compact('disciplinas'));
    }

    public function create()
    {
        return view('disciplinas.create');
    }

    /** Reglas compartidas entre store y update */
    protected function rules(?Disciplina $disciplina = null): array
    {
        return [
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('disciplinas', 'nombre')->ignore($disciplina?->id),
            ],
            'inhabilitado' => ['sometimes', 'boolean'],

        ];
    }

    protected function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la disciplina es obligatorio.',
            'nombre.max'      => 'El nombre no puede superar 100 caracteres.',
            'nombre.unique'   => 'Ya existe una disciplina con ese nombre.',
            'inhabilitado.boolean' => 'El valor de inhabilitado debe ser verdadero o falso.',

            // 'area_id.exists' => 'El área seleccionada no existe.',
        ];
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages());

        Disciplina::create($data);

        return redirect()
            ->route('disciplinas.index')
            ->with('success', 'Disciplina creada correctamente.');
    }

    public function show(Disciplina $disciplina)
    {
        return view('disciplinas.show', compact('disciplina'));
    }

    public function edit(Disciplina $disciplina)
    {
        return view('disciplinas.edit', compact('disciplina'));
    }

    public function update(Request $request, Disciplina $disciplina)
    {
        $data = $request->validate($this->rules($disciplina), $this->messages());

        $disciplina->update($data);

        return redirect()
            ->route('disciplinas.index')
            ->with('success', 'Disciplina actualizada correctamente.');
    }

    public function destroy(Disciplina $disciplina)
    {
        $disciplina->delete();

        return redirect()
            ->route('disciplinas.index')
            ->with('success', 'Disciplina eliminada correctamente.');
    }
}
