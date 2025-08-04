import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // css --------------------
                'resources/css/app.css',
                'resources/css/auth/login.css',
                'resources/css/layout.css',
                'resources/css/trangdangkydetai.css',
                // js ---------------------
                'resources/js/app.js',
                'resources/js/auth/login.js',
                'resources/js/pages/dangkydetai.js',

            ],
            refresh: true,
        }),
    ],
});
