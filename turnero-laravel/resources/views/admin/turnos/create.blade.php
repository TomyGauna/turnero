@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Nuevo Turno</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('turnos.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="hora" class="form-label">Hora</label>
                <input type="time" name="hora" id="hora" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('turnos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
