@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Turnos Disponibles</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($turnos->isEmpty())
            <p>No hay turnos disponibles por ahora.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($turnos as $turno)
                        <tr>
                            <td>{{ $turno->fecha }}</td>
                            <td>{{ $turno->hora }}</td>
                            <td>
                                <form action="{{ route('cliente.turnos.reservar', $turno->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-success">Reservar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
