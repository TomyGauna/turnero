<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $turnos = Appointment::orderBy('fecha')->orderBy('hora')->get();
        return view('admin.turnos.index', compact('turnos'));
    }

    public function create()
    {
        return view('admin.turnos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora' => 'required',
        ]);

        Appointment::create([
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'estado' => 'disponible',
        ]);

        return redirect()->route('turnos.index')->with('success', 'Turno creado con éxito.');
    }

    public function edit(Appointment $turno)
    {
        return view('admin.turnos.edit', compact('turno'));
    }

    public function update(Request $request, Appointment $turno)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora' => 'required',
            'estado' => 'required|in:disponible,reservado,cancelado',
        ]);

        $turno->update($request->all());

        return redirect()->route('turnos.index')->with('success', 'Turno actualizado.');
    }

    public function destroy(Appointment $turno)
    {
        $turno->delete();
        return redirect()->route('turnos.index')->with('success', 'Turno eliminado.');
    }
}
