@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Elegí un profesional</h1>

        @if($admins->isEmpty())
            <p>No hay administradores disponibles.</p>
        @else
            <ul class="list-group">
                @foreach($admins as $admin)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $admin->name }} ({{ $admin->email }})</span>
                        <a href="{{ route('cliente.ver_admin', $admin->id) }}" class="btn btn-info btn-sm">Ver perfil</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
