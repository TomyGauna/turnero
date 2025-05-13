@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Panel del Cliente</h1>
        <p>Hola, {{ Auth::user()->name }} (Cliente)</p>
    </div>
@endsection
