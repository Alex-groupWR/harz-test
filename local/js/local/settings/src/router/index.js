import { createRouter, createWebHashHistory } from 'vue-router';
import SettingsMain from '../views/SettingsMain.vue';

const routes = [
  {
    path: '/',
    name: 'SettingsMain',
    component: SettingsMain,
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

export default router;
