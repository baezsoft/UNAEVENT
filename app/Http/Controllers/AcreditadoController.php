<?php

namespace App\Http\Controllers;
require_once app_path('Libraries/phpqrcode/qrlib.php');

use App\Models\Acreditado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AcreditadoController extends Controller
{
    // Formulario público de registro
    public function create()
    {
        return view('acreditaciones.form');
    }

    // Guardar registro
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_evento' => 'required|exists:eventos,id',
            'dni' => 'required|unique:acreditados,dni',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'fecha_nacimiento' => 'nullable|date',
            'genero' => 'nullable|boolean',
            'nacionalidad' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:30',
            'correo' => 'nullable|email|max:150'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $acreditado = Acreditado::create([
            'id_evento' => $request->id_evento,
            'fecha_acreditacion' => now(),
            'estado' => 'pendiente',
            'dni' => $request->dni,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'genero' => $request->genero,
            'nacionalidad' => $request->nacionalidad,
            'telefono' => $request->telefono,
            'correo' => $request->correo
        ]);

        return redirect()->back()->with('success', 'Registro enviado correctamente.');
    }

    // Vista para administración
    public function index(Request $request)
    {
        $query = Acreditado::query()->with('evento'); // eager load evento si tienes relación
    
        // Filtrar por nombre
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }
    
        // Filtrar por apellido
        if ($request->filled('apellido')) {
            $query->where('apellido', 'like', '%' . $request->apellido . '%');
        }
    
        // Filtrar por DNI
        if ($request->filled('dni')) {
            $query->where('dni', 'like', '%' . $request->dni . '%');
        }
    
        // Filtrar por evento (id_evento)
        if ($request->filled('evento_id')) {
            $query->where('id_evento', $request->evento_id);
        }
    
        // Filtrar por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
    
        // Orden descendente por fecha de creación
        $acreditados = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();
    
        return view('acreditaciones.index', compact('acreditados'));
    }
    
    // Editar acreditado
    public function edit(Acreditado $acreditado)
    {
        return view('acreditaciones.edit', compact('acreditado'));
    }

    public function update(Request $request, Acreditado $acreditado)
    {
        $request->validate([
            'estado' => 'required|string|max:20',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'fecha_nacimiento' => 'nullable|date',
            'genero' => 'nullable|boolean',
            'nacionalidad' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:30',
            'correo' => 'nullable|email|max:150',
            'inhabilitado' => 'boolean'
        ]);

        $acreditado->update($request->all());
        return redirect()->route('acreditaciones.index')->with('success', 'Acreditado actualizado.');
    }

    public function buscar(Request $request)
    {
        try {
            // Solo para peticiones AJAX
            if (!$request->ajax()) {
                return response()->json(['found' => false, 'message' => 'Solicitud no válida'], 400);
            }
    
            // Validación de parámetro
            $validated = $request->validate([
                'dni' => 'required|string|max:20'
            ]);
    
            // Buscar por CI (ajustá si tu campo es distinto)
            $acreditado = Acreditado::where('dni', $validated['dni'])->first();
    
            if ($acreditado) {
                return response()->json([
                    'found' => true,
                    'id' => $acreditado->id,
                    'nombre' => trim("{$acreditado->nombre} {$acreditado->apellido}")
                ]);
            }
    
            return response()->json(['found' => false]);
    
        } catch (\Throwable $e) {
            // Loguea el error en storage/logs/laravel.log
            \Log::error('Error en buscar acreditado: ' . $e->getMessage());
            return response()->json([
                'found' => false,
                'error' => 'Error interno del servidor',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function qr(Acreditado $acreditado)
    {
        $url = route('acreditaciones.show', $acreditado->token);
    
        // Genera QR como imagen PNG en memoria
        ob_start();
        \QRcode::png($url, null, QR_ECLEVEL_L, 4);
        $imageString = ob_get_contents();
        ob_end_clean();
    
        $qrBase64 = base64_encode($imageString);
    
        return view('acreditaciones.qr', [
            'qr' => $qrBase64,
            'acreditado' => $acreditado
        ]);
    }
    // Acceso al perfil vía token
    public function show($token)
    {
        $acreditado = Acreditado::where('token', $token)->firstOrFail();
        return view('acreditaciones.show', compact('acreditado'));
    }
}
