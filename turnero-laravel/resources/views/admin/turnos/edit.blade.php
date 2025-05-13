@extends('layouts.app')

@section('content')
<div class="container">
        <h1>Editar Turno</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('turnos.update', $turno->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" name="fecha" id="fecha" value="{{ $turno->fecha }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="hora" class="form-label">Hora</label>
                <input type="time" name="hora" id="hora" value="{{ $turno->hora }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select name="estado" id="estado" class="form-select">
                    <option value="disponible" @selected($turno->estado === 'disponible')>Disponible</option>
                    <option value="reservado" @selected($turno->estado === 'reservado')>Reservado</option>
                    <option value="cancelado" @selected($turno->estado === 'cancelado')>Cancelado</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Actualizar</button>
            <a href="{{ route('turnos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection