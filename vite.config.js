import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 
            'resources/js/app.js',
             'resources/js/bootstrap.js',
              'resources/js/search.js', 
              'resources/js/task_management.js', 
              'resources/js/nav.js',
              'resources/js/nav_mobile.js',
              'resources/css/search.scss',
            ],
            refresh: true,
        }),
    ],
});
