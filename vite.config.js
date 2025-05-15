import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
import path from 'path';
import collectModuleAssetsPaths from "./vite-module-loader.js";
const allPaths = await collectModuleAssetsPaths(['resources/js/app.js', 'resources/css/app.css'], 'modules');

export default defineConfig({
    plugins: [
        laravel({
            input: allPaths,
            refresh: [
                ...refreshPaths,
                'app/Livewire/**',
                'modules/**',
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
