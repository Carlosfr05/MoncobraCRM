<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate para gestionar usuarios (solo admin y superadmin)
        Gate::define('manage-users', function (User $user) {
            return in_array($user->role, ['admin', 'superadmin']);
        });

        // Gate para ver todos los usuarios
        Gate::define('view-users', function (User $user) {
            return in_array($user->role, ['admin', 'superadmin']);
        });

        // Gate para ver detalles de un usuario específico
        Gate::define('view-user', function (User $user, User $targetUser) {
            // Solo admin y superadmin pueden ver detalles de cualquier usuario
            return in_array($user->role, ['admin', 'superadmin']);
        });

        // Gate para editar un usuario específico
        Gate::define('edit-user', function (User $user, User $targetUser) {
            // Un superadmin puede editar a todos menos sí mismo
            if ($user->role === 'superadmin') {
                return $user->id !== $targetUser->id;
            }
            // Un admin puede editar a usuarios y otros admins
            if ($user->role === 'admin') {
                return in_array($targetUser->role, ['user', 'admin']) && $user->id !== $targetUser->id;
            }
            return false;
        });

        // Gate para eliminar un usuario
        Gate::define('delete-user', function (User $user, User $targetUser) {
            // Un superadmin puede eliminar cualquiera menos sí mismo
            if ($user->role === 'superadmin') {
                return $user->id !== $targetUser->id;
            }
            // Un admin solo puede eliminar usuarios regulares
            if ($user->role === 'admin') {
                return $targetUser->role === 'user' && $user->id !== $targetUser->id;
            }
            return false;
        });

        // Gate para cambiar el rol de un usuario
        Gate::define('change-user-role', function (User $user, User $targetUser) {
            // Un superadmin puede cambiar roles a cualquiera menos sí mismo
            if ($user->role === 'superadmin') {
                return $user->id !== $targetUser->id;
            }
            // Un admin puede cambiar roles de usuarios y otros admins (pero no superadmin)
            if ($user->role === 'admin') {
                return in_array($targetUser->role, ['user', 'admin']) && $user->id !== $targetUser->id;
            }
            return false;
        });

        // Gate para gestionar proyectos (solo superadmin)
        Gate::define('manage-projects', function (User $user) {
            return $user->role === 'superadmin';
        });
    }
}

