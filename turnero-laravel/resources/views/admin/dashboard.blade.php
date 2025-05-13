@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Panel de Administración</h1>
        <p>Bienvenido, {{ Auth::user()->name }} (Admin)</p>
        <a href="{{ route('turnos.index') }}">Ver Turnos</a>
    </div>
@endsection
