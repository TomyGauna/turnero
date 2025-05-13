@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Panel del Cliente</h1>
        <p>Hola, {{ Auth::user()->name }} (Cliente)</p>
        <a href="{{ route('cliente.turnos') }}" class="btn btn-primary mt-3">
            Ver turnos disponibles
        </a>
    </div>
@endsection
