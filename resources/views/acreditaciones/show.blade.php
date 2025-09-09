@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Perfil de Acreditado</h2>

    <div class="card mt-3">
        <div class="card-body">
            <p><strong>DNI:</strong> {{ $acreditado->dni }}</p>
            <p><strong>Nombre:</strong> {{ $acreditado->nombre }} {{ $acreditado->apellido }}</p>
            <p><strong>Fecha de Nacimiento:</strong> {{ $acreditado->fecha_nacimiento?->format('d/m/Y') ?? 'N/A' }}</p>
            <p><strong>Género:</strong> {{ $acreditado->genero === true ? 'Masculino' : ($acreditado->genero === false ? 'Femenino' : 'N/A') }}</p>
            <p><strong>Correo:</strong> {{ $acreditado->correo ?? 'N/A' }}</p>
            <p><strong>Teléfono:</strong> {{ $acreditado->telefono ?? 'N/A' }}</p>
            <p><strong>Nacionalidad:</strong> {{ $acreditado->nacionalidad ?? 'N/A' }}</p>
            <p><strong>Evento:</strong> {{ $acreditado->evento->nombre ?? 'N/A' }}</p>
            <p><strong>Estado:</strong> {{ $acreditado->estado }}</p>
        </div>
    </div>

    <br>

    <div class="accordion" id="actividadesAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseActividades" aria-expanded="true" aria-controls="collapseActividades">
                    Actividades Vinculadas
                </button>
            </h2>
            <div id="collapseActividades" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#actividadesAccordion">
                <div class="accordion-body">
                    @if($acreditado->actividades->isEmpty())
                        <p>No tiene actividades asignadas.</p>
                    @else
                        <div class="row">
                            @foreach($acreditado->actividades as $actividad)
                                @php
                                    $link = url('/participantes/'.$acreditado->id.'/'.$actividad->id);
                                    // Generar QR en base64
                                    ob_start();
                                    \QRcode::png($link, null, QR_ECLEVEL_L, 4);
                                    $imageString = ob_get_contents();
                                    ob_end_clean();
                                    $qrBase64 = base64_encode($imageString);
                                @endphp
                                <div class="col-md-4 text-center mb-3">
                                    <p><strong>{{ $actividad->nombre }}</strong></p>
                                    <img src="data:image/png;base64,{{ $qrBase64 }}" alt="QR {{ $actividad->nombre }}">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <br>
    <p>Este perfil se accede mediante un enlace seguro con token, no requiere contraseña.</p>
</div>
@endsection
