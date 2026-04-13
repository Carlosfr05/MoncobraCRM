<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Crear el middleware de autorización en el constructor
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (! Gate::allows('manage-users')) {
                abort(403, 'No tienes permisos para acceder a esta sección.');
            }
            return $next($request);
        });
    }

    /**
     * Mostrar listado de usuarios
     */
    public function index()
    {
        $currentUser = auth()->user();
        
        // Admin y Superadmin ven a TODOS los usuarios
        $users = User::paginate(15);

        return view('usuarios.index', compact('users', 'currentUser'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(User $user)
    {
        $this->authorize('edit-user', $user);

        return view('usuarios.edit', compact('user'));
    }

    /**
     * Actualizar usuario
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('edit-user', $user);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin,superadmin',
            'telefono' => 'nullable|string|max:20',
            'descripcion' => 'nullable|string',
            'activo' => 'boolean',
        ]);

        // Validar que no intente cambiar su propio rol
        if ($request->user()->id === $user->id && $request->input('role') !== $user->role) {
            return back()->withErrors(['role' => 'No puedes cambiar tu propio rol.']);
        }

        // Validar cambio de rol según permisos
        if ($request->input('role') !== $user->role) {
            $this->authorize('change-user-role', $user);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Cambiar rol de un usuario (AJAX)
     */
    public function changeRole(Request $request, User $user)
    {
        $this->authorize('change-user-role', $user);

        $request->validate([
            'role' => 'required|in:user,admin,superadmin',
        ]);

        // Validar que no sea su propio rol
        if (auth()->id() === $user->id && $request->input('role') !== $user->role) {
            return response()->json(['error' => 'No puedes cambiar tu propio rol.'], 403);
        }

        // Un admin no puede asignar 'admin' ni 'superadmin'
        if (auth()->user()->role === 'admin' && in_array($request->input('role'), ['admin', 'superadmin'])) {
            return response()->json(['error' => 'No tienes permisos para asignar ese rol.'], 403);
        }

        $user->update(['role' => $request->input('role')]);

        return response()->json(['success' => true, 'message' => 'Rol actualizado correctamente.']);
    }

    /**
     * Cambiar estado de activación
     */
    public function toggleActive(Request $request, User $user)
    {
        if (auth()->id() === $user->id) {
            return response()->json(['error' => 'No puedes cambiar tu propio estado.'], 403);
        }

        $user->update(['activo' => !$user->activo]);

        return response()->json([
            'success' => true,
            'activo' => $user->activo,
            'message' => $user->activo ? 'Usuario activado.' : 'Usuario desactivado.'
        ]);
    }

    /**
     * Eliminar usuario
     */
    public function destroy(User $user)
    {
        $this->authorize('delete-user', $user);

        if (auth()->id() === $user->id) {
            return back()->withErrors(['error' => 'No puedes eliminar tu propia cuenta.']);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
    }

    /**
     * Mostrar detalles del usuario
     */
    public function show(User $user)
    {
        if (auth()->user()->role === 'admin' && $user->role !== 'user') {
            abort(403);
        }

        return view('usuarios.show', compact('user'));
    }
}
