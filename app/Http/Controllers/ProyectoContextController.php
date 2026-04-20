<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\RedirectResponse;

class ProyectoContextController extends Controller
{
    public function seleccionar(Proyecto $proyecto): RedirectResponse
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $perteneceAlProyecto = $user->role === 'superadmin' || $user
            ->proyectos()
            ->where('proyectos.id', $proyecto->id)
            ->exists();

        if (!$perteneceAlProyecto) {
            return back()->with('error', 'No tienes acceso al proyecto seleccionado.');
        }

        session(['active_proyecto_id' => $proyecto->id]);

        return back()->with('success', "Proyecto activo: {$proyecto->nombre}");
    }
}
