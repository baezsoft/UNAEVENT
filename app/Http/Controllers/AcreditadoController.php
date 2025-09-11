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

        $acreditado = Acreditado::create([
            'dni' => $request->dni,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'genero' => $request->genero,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'nacionalidad' => $request->nacionalidad,
            'id_evento' => $request->id_evento,
            'token' => \Illuminate\Support\Str::random(32),
            'fecha_acreditacion' => $request->fecha_acreditacion ?? \Carbon\Carbon::today()->toDateString()
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
