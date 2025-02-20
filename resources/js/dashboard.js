import { createApp } from 'vue'
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'

import Dashboard from './components/dashboard/Dashboard.vue'

const app = createApp({})
app.use(ElementPlus)
app.component('dashboard', Dashboard)

app.mount('#app')
