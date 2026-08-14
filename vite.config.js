import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // import css client
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
                'resources/css/client/roomdetail.css',
                'resources/css/client/success.css',
                'resources/css/client/chat-ai.css',
                'resources/css/client/animations.css',
                // import js client
                 'resources/js/client/app.js',
                 'resources/js/client/animations.js',
                 'resources/js/client/chat.js',
                 'resources/js/client/homepage.js',
                // import css admin
                'resources/css/admin/app.css',
                'resources/css/admin/rooms.css',
                'resources/css/admin/room-types.css',
                'resources/css/admin/bookings.css',

                'resources/css/admin/sidebar.css',
                'resources/css/admin/equipment-types.css',
                'resources/css/admin/footer.css',
                'resources/css/admin/login.css',
                'resources/css/admin/repair-ticket.css',
                'resources/css/admin/customers.css',
                'resources/css/admin/customers-create.css',
                'resources/css/admin/services.css',
                'resources/css/admin/service-types.css',
                'resources/css/admin/service-types-edit.css',
                'resources/css/admin/service-types-create.css',
                'resources/css/admin/amenities.css',
                'resources/css/admin/amenities-create.css',
                'resources/css/admin/staff-roles.css',
                'resources/css/admin/roles.css',
                'resources/css/admin/room-map.css',
                'resources/css/admin/equipment.css',
                'resources/css/admin/dashboard.css',
                'resources/css/admin/booking-create.css',
                'resources/js/admin/booking-create.js',
                'resources/css/admin/room-detail.css',
                'resources/css/admin/invoice.css',
                'resources/css/admin/incoming.css',
                'resources/css/admin/equipment-edit.css',
                'resources/css/admin/room-available.css',
                'resources/css/admin/room-map-edit.css',
                'resources/css/admin/room-types-edit.css',
                'resources/css/admin/repair-ticket-add.css',
                'resources/css/admin/customer-create.css',
                'resources/css/admin/customer-edit.css',
                'resources/css/admin/statistical.css',
                'resources/css/admin/statisical-revenue.css',
                'resources/css/admin/statisical-room-efficiency.css',
                'resources/css/admin/statisical-customers.css',
                'resources/css/admin/configuration.css',

                // import js admin
                'resources/js/admin/booking-create.js',
                'resources/js/admin/sidebar.js',
                'resources/js/admin/app.js',
                'resources/js/admin/dashboard.js',
                'resources/js/admin/room-detail.js',
                'resources/js/admin/equipment-types.js',
                'resources/js/admin/repair-ticket.js',
                'resources/js/admin/sidebar.js',
                'resources/js/admin/room-type-edit.js'
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
