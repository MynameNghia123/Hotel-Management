import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/client/app.css',
                'resources/css/client/amenities.css',
                'resources/css/client/dining.css',
                'resources/css/client/gallery.css',
                'resources/css/client/login.css',
                'resources/css/client/register.css',
                'resources/css/client/profile.css',
                'resources/css/client/room.css',
                'resources/css/client/search.css',
                'resources/css/client/payment.css',
                'resources/css/client/checkout.css',
                'resources/css/client/forgot_password.css',
                'resources/css/client/success.css',
                'resources/css/admin/app.css',
                'resources/js/client/app.js',
                'resources/js/admin/app.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
