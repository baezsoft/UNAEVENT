@extends('layouts.app')

@section('content') 
<div class="container">
    <h2>Nuevo Movimiento</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('movimientos.store') }}" method="POST" id="form-mov">
        @csrf

        <div class="mb-3">
            <label>Tipo</label>
            <select name="tipo" id="tipo" class="form-control" required>
                <option value="entrada">Entrada</option>
                <option value="salida">Salida</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Evento</label>
            <select name="id_evento" class="form-control">
                <option value="">-- Seleccionar --</option>
                @foreach($eventos as $ev)
                    <option value="{{ $ev->id }}">{{ $ev->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 row">
            <div class="col-md-6">
                <label>DNI del acreditado</label>
                <div class="input-group">
                    <input type="text" id="dni" class="form-control" placeholder="DNI">
                    <button type="button" id="btn-buscar-dni" class="btn btn-outline-secondary">Buscar acreditado</button>
                </div>
                <small id="ac-result" class="form-text text-muted"></small>
            </div>
            <div class="col-md-6">
                <label>Nombre encontrado</label>
                <input type="text" id="ac-nombre" class="form-control" readonly>
            </div>
        </div>

        <input type="hidden" name="id_acreditado" id="id_acreditado" value="">

        <div class="mb-3">
            <label>Monto</label>
            <input type="number" step="0.01" name="monto" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="3" class="form-control"></textarea>
            <small class="form-text text-muted">Obligatorio si tipo = salida</small>
        </div>

        <div class="mb-3">
            <label>Fecha</label>
            <input type="datetime-local" name="fecha" class="form-control">
        </div>

        <button class="btn btn-primary" type="submit">Guardar</button>
        <a href="{{ route('movimientos.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnBuscar = document.getElementById('btn-buscar-dni');
    const dniInput = document.getElementById('dni');
    const acResult = document.getElementById('ac-result');
    const acNombre = document.getElementById('ac-nombre');
    const idAcreditado = document.getElementById('id_acreditado');

    btnBuscar.addEventListener('click', function() {
        const dni = dniInput.value.trim();
        acResult.textContent = '';
        acNombre.value = '';
        idAcreditado.value = '';

        if (!dni) {
            acResult.textContent = 'Ingrese un DNI.';
            return;
        }

        acResult.textContent = 'Buscando...';

        fetch("{{ route('acreditados.buscar') }}?dni=" + encodeURIComponent(dni), {
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            credentials: 'same-origin'
        })
        .then(resp => resp.json())
        .then(json => {
            if (json.found) {
                acResult.textContent = 'Acreditado encontrado.';
                acNombre.value = json.nombre;
                idAcreditado.value = json.id;
            } else {
                acResult.textContent = 'No se encontró acreditado con ese DNI.';
                acNombre.value = '';
                idAcreditado.value = '';
            }
        })
        .catch(err => {
            acResult.textContent = 'Error al buscar acreditado.';
            console.error(err);
        });
    });

    // Forzar descripcion obligatoria si tipo = salida al enviar
    const form = document.getElementById('form-mov');
    form.addEventListener('submit', function(e){
        const tipo = document.getElementById('tipo').value;
        const desc = document.getElementById('descripcion').value.trim();
        if (tipo === 'salida' && desc.length === 0) {
            e.preventDefault();
            alert('La descripción es obligatoria para movimientos de tipo salida.');
        }
    });
});
</script>
@endsection
