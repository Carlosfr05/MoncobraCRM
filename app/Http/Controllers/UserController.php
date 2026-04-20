<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
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
        $users = User::with('proyectos')->paginate(15);

        return view('usuarios.index', compact('users', 'currentUser'));
    }

    /**
     * Mostrar formulario de creacion
     */
    public function create()
    {
        $proyectos = Proyecto::orderBy('nombre')->get();

        return view('usuarios.create', compact('proyectos'));
    }

    /**
     * Guardar nuevo usuario
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,admin,superadmin',
            'proyecto_ids' => 'nullable|array',
            'proyecto_ids.*' => 'exists:proyectos,id',
            'telefono' => 'nullable|string|max:20',
            'descripcion' => 'nullable|string|max:500',
            'activo' => 'nullable|boolean',
        ]);

        if ($request->user()->role === 'admin' && $request->input('role') === 'superadmin') {
            return back()->withErrors(['role' => 'No tienes permisos para asignar ese rol.'])->withInput();
        }

        if ($request->input('role') === 'user' && empty($validated['proyecto_ids'])) {
            return back()->withErrors(['proyecto_ids' => 'Los usuarios con rol Usuario deben tener al menos un proyecto asignado.'])->withInput();
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'telefono' => $validated['telefono'] ?? null,
            'descripcion' => $validated['descripcion'] ?? null,
            'activo' => $request->boolean('activo', true),
        ]);

        if ($user->role === 'superadmin') {
            $user->syncAllProjectsIfSuperadmin();
        } else {
            $user->proyectos()->sync($validated['proyecto_ids'] ?? []);
        }

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
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
            // Un admin no puede asignar 'superadmin'
            if ($request->user()->role === 'admin' && $request->input('role') === 'superadmin') {
                return back()->withErrors(['role' => 'No tienes permisos para asignar ese rol.']);
            }
        }

        $user->update($validated);

        if ($user->role === 'superadmin') {
            $user->syncAllProjectsIfSuperadmin();
        }

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

        // Un admin no puede asignar 'superadmin'
        if (auth()->user()->role === 'admin' && $request->input('role') === 'superadmin') {
            return response()->json(['error' => 'No tienes permisos para asignar ese rol.'], 403);
        }

        $user->update(['role' => $request->input('role')]);

        if ($user->role === 'superadmin') {
            $user->syncAllProjectsIfSuperadmin();
        }

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
        $this->authorize('view-user', $user);

        $user->load('proyectos');

        return view('usuarios.show', compact('user'));
    }
}
