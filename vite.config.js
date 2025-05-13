import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: [
                ...refreshPaths,
                'app/Livewire/**',
            ],
        }),
    ],
    resolve: {
        alias: {
            '/resources/css/lucide.woff2': path.resolve(__dirname, 'node_modules/lucide-static/font/lucide.woff2'),
            '/resources/css/lucide.woff': path.resolve(__dirname, 'node_modules/lucide-static/font/lucide.woff'),
            '/resources/css/lucide.ttf': path.resolve(__dirname, 'node_modules/lucide-static/font/lucide.ttf'),
        },
    },
});
