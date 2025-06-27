<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AppointmentController extends Controller
{
    public function index()
    {
        $turnos = Appointment::where('admin_id', auth()->id())
            ->orderBy('fecha')
            ->orderBy('hora')
            ->get();
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
            'admin_id' => auth()->id(), // ← ESTA LÍNEA ES CLAVE
        ]);

        return redirect()->route('turnos.index')->with('success', 'Turno creado.');
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
                $query->where(function ($q) {
                    $q->where('fecha', '>', Carbon::now()->toDateString())
                    ->orWhere(function ($q2) {
                        $q2->where('fecha', Carbon::now()->toDateString())
                            ->where('hora', '>', Carbon::now()->format('H:i:s'));
                    });
                });
            })
            ->orderBy('fecha')
            ->orderBy('hora')
            ->get();

        return view('cliente.turnos.index', compact('turnos'));
    }

    public function reservar($id)
    {
        $user = auth()->user();
        $turno = Appointment::findOrFail($id);

        if ($turno->estado !== 'disponible') {
            return back()->with('error', 'Este turno ya no está disponible.');
        }

        // 🚧 PROVISORIO: Suponemos que todos los turnos pertenecen a un único admin
        $regla = $user->regla_turnos ?? 'sin_limite'; // si el user es admin (luego lo cambiamos a $turno->admin->regla_turnos)
        $nivel = $user->nivel ?? 'basico';

        $query = Appointment::where('user_id', $user->id)
                            ->where('estado', 'reservado');

        $yaTiene = false;

        switch ($regla) {
            case '1_en_total':
                $yaTiene = $query->exists();
                break;

            case '1_por_dia':
                $yaTiene = $query->where('fecha', $turno->fecha)->exists();
                break;

            case '1_por_semana':
                $yaTiene = $query->whereBetween('fecha', [
                    now()->startOfWeek(), now()->endOfWeek()
                ])->exists();
                break;

            case 'sin_limite':
            default:
                $yaTiene = false;
                break;
        }

        if ($yaTiene) {
            return back()->with('error', 'Ya alcanzaste tu límite de reservas según la política del administrador.');
        }

        // Reservar
        $turno->update([
            'estado' => 'reservado',
            'user_id' => $user->id,
        ]);

        return back()->with('success', 'Turno reservado con éxito.');
    }

    public function misTurnos()
    {
        $turnos = Appointment::where('user_id', auth()->id())
                    ->where('estado', 'reservado')
                    ->orderBy('fecha')
                    ->orderBy('hora')
                    ->get();

        return view('cliente.turnos.mis_turnos', compact('turnos'));
    }

    public function cancelar($id)
    {
        $turno = Appointment::where('id', $id)
                    ->where('user_id', auth()->id())
                    ->where('estado', 'reservado')
                    ->firstOrFail();

        $turno->update([
            'estado' => 'disponible',
            'user_id' => null,
        ]);

        return back()->with('success', 'Turno cancelado correctamente.');
    }

    public function elegirAdmin()
    {
        $admins = \App\Models\User::where('role', 'admin')->get();
        return view('cliente.elegir_admin', compact('admins'));
    }

    public function verTurnosDeAdmin($adminId)
    {
        $turnos = Appointment::where('admin_id', $adminId)
            ->where('estado', 'disponible')
            ->where(function ($q) {
                $q->where('fecha', '>', now()->toDateString())
                ->orWhere(function ($q2) {
                    $q2->where('fecha', now()->toDateString())
                        ->where('hora', '>', now()->format('H:i:s'));
                });
            })
            ->orderBy('fecha')
            ->orderBy('hora')
            ->get();

        $admin = \App\Models\User::findOrFail($adminId);

        return view('cliente.turnos.index_admin', compact('turnos', 'admin'));
    }

    public function verAdmin($adminId)
    {
        $admin = \App\Models\User::where('id', $adminId)->where('role', 'admin')->firstOrFail();
        return view('cliente.turnos.ver_admin', compact('admin'));
    }

    public function verCliente($id)
    {
        $cliente = \App\Models\User::where('id', $id)->where('role', 'cliente')->firstOrFail();
        return view('admin.clientes.ver_cliente', compact('cliente'));
    }
}
