<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimiento;
use App\Models\Evento;
use App\Models\Acreditado;
use Carbon\Carbon;

class MovimientosController extends Controller
{
    // Mostrar listado con filtros
    public function index(Request $request)
    {
        $filtros = $request->only(['tipo', 'id_evento', 'id_acreditado', 'fecha_desde', 'fecha_hasta']);
        $query = Movimiento::obtenerMovimientos($filtros);

        $movimientos = $query->paginate(15)->appends($request->query());
        $eventos = Evento::orderBy('nombre')->get();

        return view('movimientos.index', compact('movimientos', 'eventos', 'filtros'));
    }

    // Formulario nuevo movimiento
    public function create()
    {
        $eventos = Evento::orderBy('nombre')->get();
        return view('movimientos.create', compact('eventos'));
    }

    // Guardar movimiento
    public function store(Request $request)
    {
        $rules = [
            'tipo' => 'required|in:entrada,salida',
            'monto' => 'required|numeric|min:0',
            'id_evento' => 'nullable|exists:eventos,id',
            'id_acreditado' => 'nullable|exists:acreditados,id',
            'fecha' => 'nullable|date',
        ];
    
        // Si es egreso, la descripción es obligatoria
        $rules['descripcion'] = $request->input('tipo') === 'salida'
            ? 'required|string|max:2000'
            : 'nullable|string|max:2000';
    
        $validated = $request->validate($rules);
    
        // Caso especial: si es entrada y tiene acreditado → aprobarlo
        if ($validated['tipo'] === 'entrada' && !empty($validated['id_acreditado'])) {
            $acreditado = Acreditado::find($validated['id_acreditado']);
            if ($acreditado) {
                $acreditado->estado = 'Aprobado';
                $acreditado->save();
            }
        }
    
        // Crear el movimiento
        Movimiento::crearMovimiento([
            'id_evento' => $validated['id_evento'] ?? null,
            'id_acreditado' => $validated['id_acreditado'] ?? null,
            'tipo' => $validated['tipo'],
            'monto' => $validated['monto'],
            'descripcion' => $validated['descripcion'] ?? null,
            'fecha' => $validated['fecha'] ?? Carbon::now(),
        ]);
    
        return redirect()
            ->route('movimientos.index')
            ->with('success', 'Movimiento registrado correctamente y acreditado aprobado.');
    }
    

    // Inhabilitar (no borrar)
    public function inhabilitar($id)
    {
        $ok = Movimiento::inhabilitarMovimiento($id);
        if ($ok) {
            return redirect()->back()->with('success', 'Movimiento inhabilitado.');
        }
        return redirect()->back()->with('error', 'Movimiento no encontrado.');
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
            $acreditado = Acreditado::where('ci', $validated['dni'])->first();
    
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
    
}
