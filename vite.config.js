import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(({command, mode, ssrBuild}) => {
    if (command === 'serve') {
        return {
            server: {
                host: '0.0.0.0',
                hmr: {
                    // host: 'localhost',
                    host: 'laravel.test',
                },
                watch: {
                    usePolling: true,
                },
            },
            build: {
                manifest: true,
                outDir: 'public/build',
                rollupOptions: {
                    input: [
                        'resources/sass/app.scss',
                        'resources/js/app.js',
                    ],
                },
                target: ['esnext']
            },
            plugins: [
                laravel({
                    input: [
                        'resources/sass/app.scss',
                        'resources/js/app.js',
                    ],
                    refresh: true,
                }),
            ]
        }
    } else {
        return {
            server: {
                host: '0.0.0.0',
                hmr: {
                    // host: 'localhost',
                    host: 'laravel.test',
                },
                watch: {
                    usePolling: true,
                },
            },
            build: {
                manifest: true,
                outDir: 'public/build',
                rollupOptions: {
                    input: [
                        'resources/sass/app.scss',
                        'resources/js/app.js',
                    ],
                },
                target: ['esnext']
            },
            plugins: [
                laravel({
                    input: [
                        'resources/sass/app.scss',
                        'resources/js/app.js',
                    ],
                    refresh: true,
                }),
            ]
        }
    }
});
