<?php

namespace App\Http\Controllers;

require_once app_path('Libraries/phpqrcode/qrlib.php');

use App\Models\Acreditado;
use App\Models\Participante;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AcreditadoController extends Controller
{
    // Formulario público de registro
    public function create()
    {
        $eventos = Evento::all(); // Para el select de eventos
        return view('acreditaciones.form', compact('eventos'));
    }

    // Guardar registro
    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'direccion' => 'nullable|string|max:200',
            'password' => 'required|string|min:8',
            'correo' => 'required|email|unique:acreditados,correo',
            'tel' => 'nullable|string|max:30',
            'estado' => 'nullable|in:activo,inactivo',
            'ci' => 'nullable|string|max:20|unique:acreditados,ci',
            'cargo' => 'nullable|string|max:50',
            'inhabilitado' => 'boolean',
            // Ejemplo de clave foránea:
            'id_evento' => 'required|exists:eventos,id',
        ];

        $messages = [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede superar 100 caracteres.',
            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.max' => 'El apellido no puede superar 100 caracteres.',
            'direccion.max' => 'La dirección no puede superar 200 caracteres.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'El correo debe tener un formato válido.',
            'correo.unique' => 'El correo ya está registrado.',
            'tel.max' => 'El teléfono no puede superar 30 caracteres.',
            'estado.in' => 'El estado debe ser "activo" o "inactivo".',
            'ci.max' => 'El CI no puede superar 20 caracteres.',
            'ci.unique' => 'El CI ya está registrado.',
            'cargo.max' => 'El cargo no puede superar 50 caracteres.',
            'inhabilitado.boolean' => 'El campo inhabilitado debe ser verdadero o falso.',
            'id_evento.exists' => 'El evento seleccionado no existe.',
        ];

        $validated = $request->validate($rules, $messages);

        $acreditado = Acreditado::create([
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'direccion' => $validated['direccion'] ?? null,
            'password' => Hash::make($validated['password']),
            'correo' => $validated['correo'],
            'telefono' => $validated['tel'] ?? null,
            'estado' => $validated['estado'] ?? null,
            'ci' => $validated['ci'] ?? null,
            'cargo' => $validated['cargo'] ?? null,
            'inhabilitado' => $validated['inhabilitado'] ?? false,
            'id_evento' => $validated['id_evento'],
            'token' => Str::random(32),
            'fecha_acreditacion' => $request->fecha_acreditacion ?? Carbon::today()->toDateString()
        ]);
        
        // Guardar actividades seleccionadas
        foreach ($request->actividades as $actividadId) {
            $acreditado->participantes()->create([
                'id_actividad' => $actividadId
            ]);
        }
        
        return redirect()->route('acreditaciones.index')
                         ->with('success', 'Acreditado registrado correctamente con sus actividades.');
    }

    // Vista de administración
    public function index(Request $request)
    {
        $query = Acreditado::with('evento'); // eager load evento

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('apellido')) {
            $query->where('apellido', 'like', '%' . $request->apellido . '%');
        }

        if ($request->filled('dni')) {
            $query->where('dni', 'like', '%' . $request->dni . '%');
        }

        if ($request->filled('evento_id')) {
            $query->where('id_evento', $request->evento_id);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $acreditados = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();

        return view('acreditaciones.index', compact('acreditados'));
    }

    // Editar acreditado
    public function edit(Acreditado $acreditado)
    {
        $eventos = Evento::all();
        $actividadesSeleccionadas = $acreditado->participantes->pluck('id_actividad')->toArray();

        return view('acreditaciones.edit', compact('acreditado', 'eventos', 'actividadesSeleccionadas'));
    }

    // Actualizar acreditado
    public function update(Request $request, Acreditado $acreditado)
    {
        $rules = [
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'direccion' => 'nullable|string|max:200',
            'password' => 'nullable|string|min:8',
            'correo' => 'required|email|unique:acreditados,correo,' . $acreditado->id,
            'tel' => 'nullable|string|max:30',
            'estado' => 'nullable|in:activo,inactivo',
            'ci' => 'nullable|string|max:20|unique:acreditados,ci,' . $acreditado->id,
            'cargo' => 'nullable|string|max:50',
            'inhabilitado' => 'boolean',
            'id_evento' => 'required|exists:eventos,id',
        ];

        $messages = [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede superar 100 caracteres.',
            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.max' => 'El apellido no puede superar 100 caracteres.',
            'direccion.max' => 'La dirección no puede superar 200 caracteres.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'El correo debe tener un formato válido.',
            'correo.unique' => 'El correo ya está registrado.',
            'tel.max' => 'El teléfono no puede superar 30 caracteres.',
            'estado.in' => 'El estado debe ser "activo" o "inactivo".',
            'ci.max' => 'El CI no puede superar 20 caracteres.',
            'ci.unique' => 'El CI ya está registrado.',
            'cargo.max' => 'El cargo no puede superar 50 caracteres.',
            'inhabilitado.boolean' => 'El campo inhabilitado debe ser verdadero o falso.',
            'id_evento.exists' => 'El evento seleccionado no existe.',
        ];

        $validated = $request->validate($rules, $messages);

        $data = $validated;
        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        } else {
            unset($data['password']);
        }

        $acreditado->update($data);

        return redirect()->route('acreditaciones.index')->with('success', 'Acreditado actualizado.');
    }

    // Generar QR
    public function qr(Acreditado $acreditado)
    {
        $url = "http://192.168.57.29:8000/acreditaciones/perfil/{$acreditado->token}";
    
        ob_start();
        \QRcode::png($url, null, QR_ECLEVEL_L, 4);
        $imageString = ob_get_contents();
        ob_end_clean();
    
        $qrBase64 = base64_encode($imageString);
    
        return view('acreditaciones.qr', [
            'qr' => $qrBase64,
            'acreditado' => $acreditado,
            'url' => $url, // 👈 también lo mandás a la vista si querés mostrarlo en texto
        ]);
    }
    

    // Acceso al perfil vía token
    public function show($token)
    {
        $acreditado = Acreditado::where('token', $token)->firstOrFail();
    
        // Cargar actividades vinculadas
        $acreditado->load('actividades');
    
        return view('acreditaciones.show', compact('acreditado'));
    }
    

}
