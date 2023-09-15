import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({

    //追加
    server: {
        host: true,
        hmr: {
            host: 'localhost'
        }
    },
    watch: {
        usePolling: true,
    },
    //ここまで
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    
});
