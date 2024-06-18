import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    
    plugins: [
        laravel({
            input:[
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/busca_evento.css',
                'resources/css/checkout.css',
                'resources/css/evento.css',
                'resources/js/evento.js',
                'resources/css/home.css',
                'resources/js/home.js',
                'resources/css/login.css',
                'resources/js/login.js',
                'resources/css/pago.css',
                'resources/js/pago.js',
                'resources/css/panel_rol_especial.css',
                'resources/js/panel_rol_especial.js', ],
            refresh: true
        }),
    ],
});
