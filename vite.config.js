import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { quasar } from '@quasar/vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
          input: [
            'resources/sass/app.scss',
            'resources/js/app.js',
          ],
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
        quasar({
          sassVariables: 'resources/sass/quasar-variables.sass',
        }),
      ],
      resolve: {
        alias: {
          vue: 'vue/dist/vue.esm-bundler.js',
          "@": "/resources/js",
        },
      },

});
