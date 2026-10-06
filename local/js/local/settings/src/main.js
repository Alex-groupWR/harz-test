import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import 'element-plus/dist/index.css';

import { createPinia } from 'pinia';
import 'element-plus/dist/index.css';

const app = createApp(App);
const pinia = createPinia();

app.use(router);
app.use(pinia);

document.addEventListener('DOMContentLoaded', function () {
  app.mount('#app');
});
