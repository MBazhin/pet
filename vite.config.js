import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
        tailwindcss(),
    ],
    resolve: {
        alias: {
            // The alias from vue to vue.esm-bundler.js instructs Vite to use a version of Vue.js that also bundles the compiler which will allow us to write HTML instead of render() functions
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
});
