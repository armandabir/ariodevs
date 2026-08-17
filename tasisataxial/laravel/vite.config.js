import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/index.css', 
                'resources/js/index.jsx',
                // 'resources/js/app.js',
                'resources/sass/app.scss',
                
            ],
            refresh: true,
        }),
        

            react(),
    ],
        base:'/tasisataxial',

      server: {
        host: '0.0.0.0', // Use localhost or your machine's IP address
        port: 5173, // Ensure the port matches your setup
        hmr: {
            host: '127.0.0.1', // Use localhost for HMR

        },
        cors: {
            origin: '*', // Allow all origins (adjust as needed)
            methods: ['GET', 'POST'],
            headers: ['Content-Type', 'Authorization']
          }
      
    },
});
