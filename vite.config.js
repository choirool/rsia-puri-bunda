import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

import fs from 'fs'
import path from 'path'

const getJavaScriptFiles = (dir, fileList = []) => {
    const files = fs.readdirSync(dir)

    files.forEach((file) => {
        const filePath = path.join(dir, file)
        if (fs.statSync(filePath).isDirectory()) {
            getJavaScriptFiles(filePath, fileList)
        } else if (file.endsWith('.js') && file !== 'bootstrap.js') {
            fileList.push(filePath.replace(/\\/g, '/'))
        }
    })

    return fileList
}

const jsFiles = getJavaScriptFiles(path.resolve(__dirname, 'resources/js'))

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', ...jsFiles],
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
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
});
