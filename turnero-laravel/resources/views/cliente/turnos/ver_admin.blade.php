@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $admin->name }}</h1>
        <p><strong>Email:</strong> {{ $admin->email }}</p>
        @if($admin->regla_turnos)
            <p><strong>Regla de reservas:</strong> 
                @switch($admin->regla_turnos)
                    @case('1_en_total') 1 turno en total @break
                    @case('1_por_dia') 1 turno por día @break
                    @case('1_por_semana') 1 turno por semana @break
                    @default Sin límite
                @endswitch
            </p>
        @endif

        <a href="{{ route('cliente.ver_turnos_admin', $admin->id) }}" class="btn btn-primary mt-3">
            Ver turnos disponibles
        </a>
    </div>
@endsection
