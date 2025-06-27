@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Mis Turnos Reservados</h1>

        @if($turnos->isEmpty())
            <p>No tenés turnos reservados.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($turnos as $turno)
                        <tr>
                            <td>{{ $turno->fecha }}</td>
                            <td>{{ $turno->hora }}</td>
                            <td>{{ $turno->estado }}</td>
                            <td>
                                <form action="{{ route('cliente.turnos.cancelar', $turno->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que querés cancelar este turno?')">
                                    @csrf
                                    <button class="btn btn-sm btn-danger">Cancelar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
