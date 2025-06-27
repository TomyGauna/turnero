@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Turnos Disponibles</h1>

        <form method="GET" action="{{ route('cliente.turnos') }}" class="mb-4">
            <label for="admin_id">Filtrar por profesional:</label>
            <select name="admin" id="admin_id" onchange="this.form.submit()" class="form-control w-auto d-inline-block">
                <option value="">Todos</option>
                @foreach($admins as $admin)
                    <option value="{{ $admin->id }}" {{ request('admin') == $admin->id ? 'selected' : '' }}>
                        {{ $admin->name }}
                    </option>
                @endforeach
            </select>
        </form>

        @if($adminSeleccionado)
            <p class="text-muted">Viendo turnos con <strong>{{ $adminSeleccionado->name }}</strong></p>
        @endif

        @if($turnos->isEmpty())
            <p>No hay turnos disponibles.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Profesional</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($turnos as $turno)
                        <tr>
                            <td>{{ $turno->fecha }}</td>
                            <td>{{ $turno->hora }}</td>
                            <td>{{ $turno->admin->name }}</td>
                            <td>
                                <form action="{{ route('cliente.turnos.reservar', $turno->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Reservar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
