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

    public function verDisponibles()
    {
        $turnos = Appointment::where('estado', 'disponible')
            ->where(function ($query) {
                $query->where('fecha', '>', now()->toDateString())
                    ->orWhere(function ($q) {
                        $q->where('fecha', now()->toDateString())
                            ->where('hora', '>', now()->format('H:i:s'));
                    });
            })
            ->orderBy('fecha')
            ->orderBy('hora')
            ->get();

        return view('cliente.turnos.index', compact('turnos'));
    }

    public function reservar($id)
    {
        $turno = Appointment::findOrFail($id);

        if ($turno->estado !== 'disponible') {
            return back()->with('error', 'Este turno ya no está disponible.');
        }

        $turno->update([
            'estado' => 'reservado',
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Turno reservado con éxito.');
    }
}
