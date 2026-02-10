import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import FullReload from 'vite-plugin-full-reload';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            // refresh: [
            //     'app/Filament/**',
            //     'app/Models/**',
            //     'app/Providers/Filament/**',
            //     'resources/views/**',
            //     'routes/**',
            // ],
        }),
        FullReload(['app/Filament/**', 'app/Models/**', 'app/Providers/Filament/**',]),
    ],
    server: { 
        host: '127.0.0.1',
        port: 5173,
        hmr: {
            host: '127.0.0.1',
        },
    },
});
