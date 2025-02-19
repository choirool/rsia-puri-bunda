import { createApp } from 'vue'
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'

const app = createApp({})
app.use(ElementPlus)

const files = import.meta.glob('./components/position/*.vue', { eager: true })

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
