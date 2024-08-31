import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import LoginView from '@/views/LoginView.vue';
import { isMentorAuthenticated } from '@/services/authentication';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    }
  ]
});

router.beforeEach((to) => {
  if (!isMentorAuthenticated() && to.name !== 'login') {
    return { name: 'login' };
  } else if (isMentorAuthenticated() && to.name === 'login') {
    return { name: 'home' };
  }
  return true;
});

export default router;
