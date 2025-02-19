import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from 'vue'
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'

const app = createApp({})
app.use(ElementPlus)

// Auto-import semua komponen di folder components (termasuk subfolder)
const files = import.meta.glob('./components/**/*.vue', { eager: true })

for (const path in files) {
    const name = path
        .replace(/^\.\/components\//, '')
        .replace(/\.\w+$/, '')
        .split('/')
        .map(word => word.charAt(0).toUpperCase() + word.slice(1))
        .join('')

    app.component(name, files[path].default)
}

app.mount('#app')

