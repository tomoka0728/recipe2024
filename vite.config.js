import path from 'path';
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/ingredients.js',
                'resources/js/recipetop.js',
                'resources/js/pointToggle.js',
                'resources/js/top.js',
                'resources/js/cartDelete.js',
                'resources/js/cartUpdate.js',
                'resources/js/registerValidation.js',
                'resources/js/addressValidation.js',
                'resources/js/recipe_form.js',
                // 'resources/img/user.png',

            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
           '@': path.resolve(__dirname, 'resources/js'),
        },
    },
});
