@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $cliente->name }}</h1>
        <p><strong>Email:</strong> {{ $cliente->email }}</p>
        <p><strong>Nivel:</strong> {{ $cliente->nivel }}</p>
        <p><strong>Turnos reservados:</strong> {{ $cliente->appointments()->where('estado', 'reservado')->count() }}</p>
    </div>
@endsection
