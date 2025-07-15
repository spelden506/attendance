import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],

    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/dashboard.css', // <-- ADD THIS LINE
                'resources/js/app.js',
                'resources/js/dashboard.js',   // <-- ADD THIS LINE
            ],
            refresh: true,
        }),
    ],
});

