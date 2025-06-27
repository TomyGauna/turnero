<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// 🔁 Redirección según el rol
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('cliente.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 🔐 Rutas protegidas por auth
Route::middleware('auth')->group(function () {

    // 🧑 Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🛠 Panel Admin
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->middleware('role:admin')->name('admin.dashboard');

    // 🧾 Panel Cliente
    Route::get('/cliente', function () {
        return view('cliente.dashboard');
    })->middleware('role:cliente')->name('cliente.dashboard');

    Route::middleware('role:admin')->group(function () {
        Route::resource('admin/turnos', \App\Http\Controllers\AppointmentController::class);
        Route::get('/admin/cliente/{id}', [\App\Http\Controllers\AppointmentController::class, 'verCliente'])->name('admin.ver_cliente');
    });

    Route::middleware('role:cliente')->group(function () {
        Route::get('/cliente/turnos', [\App\Http\Controllers\AppointmentController::class, 'verDisponibles'])->name('cliente.turnos');
        Route::post('/cliente/turnos/{id}/reservar', [\App\Http\Controllers\AppointmentController::class, 'reservar'])->name('cliente.turnos.reservar');
        Route::get('/cliente/turnos/{admin?}', [\App\Http\Controllers\AppointmentController::class, 'verDisponibles'])->name('cliente.turnos');
        Route::get('/cliente/mis-turnos', [\App\Http\Controllers\AppointmentController::class, 'misTurnos'])->name('cliente.mis_turnos');
        Route::post('/cliente/mis-turnos/{id}/cancelar', [\App\Http\Controllers\AppointmentController::class, 'cancelar'])->name('cliente.turnos.cancelar');
        Route::get('/cliente/admins', [\App\Http\Controllers\AppointmentController::class, 'elegirAdmin'])->name('cliente.elegir_admin');
        Route::get('/cliente/turnos/admin/{admin}', [\App\Http\Controllers\AppointmentController::class, 'verTurnosDeAdmin'])->name('cliente.ver_turnos_admin');
        Route::get('/cliente/ver-admin/{admin}', [\App\Http\Controllers\AppointmentController::class, 'verAdmin'])->name('cliente.ver_admin');
    });
});

require __DIR__.'/auth.php';
