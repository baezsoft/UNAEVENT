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

        // si es egreso, descripcion obligatorio
        if ($request->input('tipo') === 'salida') {
            $rules['descripcion'] = 'required|string|max:2000';
        } else {
            $rules['descripcion'] = 'nullable|string|max:2000';
        }

        $validated = $request->validate($rules);

        // Caso especial: inscripción (entrada con id_acreditado)
        if ($validated['tipo'] === 'entrada' && !empty($validated['id_acreditado'])) {
            $ac = Acreditado::find($validated['id_acreditado']);
            if ($ac) {
                $ac->estado = 'activo';
                $ac->save();
            }
        }

        // Insertar movimiento usando el método del modelo
        $mov = Movimiento::crearMovimiento([
            'id_evento' => $validated['id_evento'] ?? null,
            'id_acreditado' => $validated['id_acreditado'] ?? null,
            'tipo' => $validated['tipo'],
            'monto' => $validated['monto'],
            'descripcion' => $validated['descripcion'] ?? null,
            'fecha' => $validated['fecha'] ?? Carbon::now(),
        ]);

        return redirect()->route('movimientos.index')->with('success', 'Movimiento registrado correctamente.');
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

    // Ruta AJAX: buscar acreditado por DNI
    public function buscarAcreditadoPorDNI(Request $request)
    {
        $dni = $request->get('dni');
        if (! $dni) {
            return response()->json(['error' => 'DNI requerido.'], 422);
        }

        $ac = Acreditado::where('dni', $dni)->first();

        if (! $ac) {
            return response()->json(['found' => false], 200);
        }

        return response()->json([
            'found' => true,
            'id' => $ac->id,
            'nombre' => ($ac->nombre ?? '') . ' ' . ($ac->apellido ?? ''),
            'estado' => $ac->estado ?? null,
        ], 200);
    }
}
