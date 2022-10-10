import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    // server: {
    //     proxy: {
    //     '/api': {
    //         target: 'http://localhost/',
    //         changeOrigin: true,
    //         secure: false,
    //         rewrite: (path) => path.replace(/^\/api/, '')
    //     },
    //     cors:false
    //     },
    // },
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            ssr: 'resources/js/ssr.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    ssr: {
        noExternal: ['@inertiajs/server'],
    },
});
