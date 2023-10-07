import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,

        }),
    ],
    server: {
        host: '0.0.0.0', // Set to this to expose to the network
        port: 5173,      // Set a custom port
        proxy: {
          // Proxying some URLs can be useful when you have a separate API backend development server
          // and you want to send API requests on the same domain.
          // '/': 'http://localhost:8113'
        }
      },
});
