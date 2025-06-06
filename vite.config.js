import path from 'path';
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/admin.css',
                'resources/css/app.css',
                'resources/css/cart.css',
                'resources/css/column.css',
                'resources/css/common.css',
                'resources/css/item.css',
                'resources/css/membership.css',
                'resources/css/mypage.css',
                'resources/css/ranking.css',
                'resources/css/recipe-index.css',
                'resources/css/recipe.css',
                'resources/css/style.css',
                'resources/css/top.css',
                'resources/js/admin.js',
                'resources/js/app.js',
                'resources/js/bootstrap.js',
                'resources/js/ingredients.js',
                'resources/js/recipetop.js',
                'resources/js/pointToggle.js',
                'resources/js/top.js',
                'resources/js/cartDelete.js',
                'resources/js/cartMove.js',
                'resources/js/cartUpdate.js',
                'resources/js/common.js',
                'resources/js/ingredients.js',
                'resources/js/membership.js',
                'resources/js/pointToggle.js',
                'resources/js/recipetop.js',
                'resources/js/registerValidation.js',
                'resources/js/sales-chart.js',
                'resources/js/saveForLaterDelete.js',
                'resources/js/addressValidation.js',
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
