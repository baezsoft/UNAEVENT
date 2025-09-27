<?php

namespace App\Http\Controllers;

use App\Models\Disertante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DisertanteController extends Controller
{
    public function index(Request $request)
    {
        $query = Disertante::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
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

    /**
     * Reglas compartidas. Acepta texto para CV (requerimiento) y, por compatibilidad,
     * si llega un archivo, valida como file pdf/doc/docx (no rompe tu flujo actual).
     */
    protected function rules(Request $request, ?Disertante $disertante = null): array
    {
        return [
            'nombre'       => ['required', 'string', 'max:100'],
            'apellido'     => ['required', 'string', 'max:100'],
            'correo'       => [
                'required',
                'email',
                Rule::unique('disertantes', 'correo')->ignore($disertante?->id),
            ],
            'telefono'     => ['nullable', 'string', 'max:30'],
            'institucion'  => ['nullable', 'string', 'max:150'],
            'especialidad' => ['nullable', 'string', 'max:100'],
            'inhabilitado' => ['sometimes', 'boolean'],

            'cv' => $request->hasFile('cv')
                ? ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:2048']
                : ['nullable', 'string'],

        ];
    }

    protected function messages(): array
    {
        return [
            'nombre.required'   => 'El nombre es obligatorio.',
            'nombre.max'        => 'El nombre no puede superar 100 caracteres.',
            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.max'      => 'El apellido no puede superar 100 caracteres.',

            'correo.required' => 'El correo es obligatorio.',
            'correo.email'    => 'Ingresa un correo válido.',
            'correo.unique'   => 'Ya existe un disertante con ese correo.',

            'telefono.max'     => 'El teléfono no puede superar 30 caracteres.',
            'institucion.max'  => 'La institución no puede superar 150 caracteres.',
            'especialidad.max' => 'La especialidad no puede superar 100 caracteres.',

            'inhabilitado.boolean' => 'El valor de inhabilitado debe ser verdadero o falso.',

            'cv.string'   => 'El CV debe ser un texto (URL, descripción o ruta).',
            'cv.file'     => 'El CV debe ser un archivo válido.',
            'cv.mimes'    => 'El CV debe ser un PDF o documento Word.',
            'cv.max'      => 'El CV no puede exceder 2MB.',

            // 'pais_id.exists'      => 'El país seleccionado no existe.',
            // 'provincia_id.exists' => 'La provincia seleccionada no existe.',
        ];
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules($request), $this->messages());

        // Compatibilidad: si subes archivo, lo guardamos y persistimos la ruta
        if ($request->hasFile('cv')) {
            $data['cv'] = $request->file('cv')->store('cv_disertantes', 'public');
        }

        Disertante::create($data);

        return redirect()
            ->route('disertantes.index')
            ->with('success', 'Disertante creado correctamente.');
    }

    public function update(Request $request, Disertante $disertante)
    {
        $data = $request->validate($this->rules($request, $disertante), $this->messages());

        // Compatibilidad: si llega archivo nuevo, reemplazamos el anterior
        if ($request->hasFile('cv')) {
            if ($disertante->cv && Storage::disk('public')->exists($disertante->cv)) {
                Storage::disk('public')->delete($disertante->cv);
            }
            $data['cv'] = $request->file('cv')->store('cv_disertantes', 'public');
        }

        $disertante->update($data);

        return redirect()
            ->route('disertantes.index')
            ->with('success', 'Disertante actualizado correctamente.');
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
        // Si guardas archivos y quieres limpiar:
        if ($disertante->cv && Storage::disk('public')->exists($disertante->cv)) {
            Storage::disk('public')->delete($disertante->cv);
        }

        $disertante->delete();

        return redirect()
            ->route('disertantes.index')
            ->with('success', 'Disertante eliminado correctamente.');
    }
}
