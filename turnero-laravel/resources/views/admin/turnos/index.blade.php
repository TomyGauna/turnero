@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Turnos</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('turnos.create') }}" class="btn btn-primary mb-3">Nuevo Turno</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Reservado por</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($turnos as $turno)
                    <tr>
                        <td>{{ $turno->fecha }}</td>
                        <td>{{ $turno->hora }}</td>
                        <td>{{ $turno->estado }}</td>
                        <td>{{ $turno->user?->name ?? '-' }}</td>
                        <td>
                            <a href="{{ route('turnos.edit', $turno->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('turnos.destroy', $turno->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este turno?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No hay turnos cargados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
