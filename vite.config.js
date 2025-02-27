import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/src/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        vue()
    ],
    server: {
        historyApiFallback: true, // ✅ Enables Vue Router handling
    }
});
