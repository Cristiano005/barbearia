import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/signin',
      name: 'signin',
      component: () => import('../views/SignInView.vue')
    },
    {
      path: '/',
      name: 'home',
      component: () => import('../views/HomeView.vue')
    },
    /* {
      path: '/schedules',
      name: 'schedules',
      component: () => import('../views/SchedulesView.vue')
    }, */
    {
      path: '/services',
      name: 'services',
      component: () => import('../views/ServicesView.vue')
    }
  ]
});

export default router;