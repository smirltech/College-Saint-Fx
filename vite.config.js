import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: [{
                paths: [
                    'app/**',
                    'config/**',
                    'public/images/**',
                    'lang/**',
                    'resources/lang/**',
                    'resources/views/**',
                    'routes/**',
                ],
                /*config: {delay: 300},*/
            }],
        }),
    ],
});
