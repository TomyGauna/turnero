@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Panel del Cliente</h1>
        <p>Hola, {{ Auth::user()->name }} (Cliente)</p>
        <a href="{{ route('cliente.turnos') }}" class="btn btn-primary mt-3">
            Ver turnos disponibles
        </a>
        <a href="{{ route('cliente.mis_turnos') }}" class="btn btn-outline-primary mt-2">
            Ver mis turnos reservados
        </a>
    </div>
@endsection
