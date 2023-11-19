import './bootstrap';
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { Quasar, Notify } from 'quasar'

// Import icon libraries
import '@quasar/extras/material-icons/material-icons.css'

// Import Quasar css
import 'quasar/src/css/index.sass';

import router from '@/routes';
import App from '@/App.vue';

const pinia = createPinia()
const myApp = createApp(App)

myApp.use(pinia)
myApp.use(router)

myApp.use(Quasar, {
  plugins: {
    Notify,
  },
})

myApp.mount('#q-app')
