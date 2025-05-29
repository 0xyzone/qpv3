import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from 'tailwindcss';
import autoprefixer from 'autoprefixer';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/filament/mukhiyas/theme.css',
                'resources/css/app.css', // Make sure this is included
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    css: {
        postcss: {
            plugins: [
                tailwindcss(),
                autoprefixer(),
            ],
        },
    },
    build: {
        outDir: 'public/build/filament',
    },
    server: {
        host: 'qpv2',
        port: 5174,
        strictPort: true,
        hmr: {
            host: 'qpv2',
            port: 5174,
        }
    }
});