import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import * as fs from 'fs';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                ...fs.readdirSync('resources/js/profile').map(file => `resources/js/profile/${file}`)
            ],
            refresh: false,
        }),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0',
        hmr: {
            host: 'davernime.test',
        },
        allowedHosts: ['davernime.test'],
    },
});
