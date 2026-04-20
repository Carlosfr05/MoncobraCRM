import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/css/login.css',
                'resources/css/register.css',
                'resources/css/reset-password.css',
                'resources/css/show_profile.css',
                'resources/css/usuarios-panel.css',
                'resources/css/usuarios-edit.css',
                'resources/css/usuarios-create.css',
                'resources/css/gestion-proyectos.css',
                'resources/css/proyecto-create.css',
                'resources/css/proyecto-edit.css',
                'resources/css/proyecto-show.css',
            ],
            refresh: true,
        }),
    ],
});
