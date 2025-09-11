@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">📊 Dashboard</h2>
    <div class="row">
        <div class="col-md-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5>Total Eventos</h5>
                    <h2>{{ $totalEventos }}</h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5>Acreditados</h5>
                    <h2>{{ $totalAcreditados }}</h2>
                    <small>Activos: {{ $acreditadosActivos }} | Inhabilitados: {{ $acreditadosInhabilitados }}</small>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5>Disertantes</h5>
                    <h2>{{ $totalDisertantes }}</h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5>Actividades Hoy</h5>
                    <h2>{{ $actividadesHoy }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h5>Eventos Próximos</h5>
                    <p>{{ $eventosProximos }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h5>Participación</h5>
                    <p>Total: {{ $totalParticipantes }}</p>
                    <p>Con asistencia: {{ $participantesConAsistencia }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
