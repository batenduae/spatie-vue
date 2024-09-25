import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import Unimport from 'unimport/unplugin'
//

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
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
        Unimport.vite({
            addons: {
                vueTemplate: true
            },
            imports: [{name: 'push', from: 'notivue'}]
        }),
    ],
});

