import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    // Otimizar build para produção
    build: {
        // Habilitar minificação para CSS e JS
        minify: 'terser',
        // Configurações do Terser para melhor minificação
        terserOptions: {
            compress: {
                drop_console: true,
                drop_debugger: true,
            },
        },
        // Dividir código em chunks para melhor cache
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['jquery', 'bootstrap', 'chart.js'],
                    utils: ['lodash', 'moment'],
                },
                // Adicionar hash aos nomes dos arquivos para cache busting
                entryFileNames: 'assets/[name]-[hash].js',
                chunkFileNames: 'assets/[name]-[hash].js',
                assetFileNames: 'assets/[name]-[hash].[ext]',
            },
        },
        // Comprimir assets
        assetsInlineLimit: 4096,
        // Gerar source maps para produção
        sourcemap: false,
        // Melhorar performance de build
        cssCodeSplit: true,
        // Otimizar CSS
        cssMinify: true,
    },
});
