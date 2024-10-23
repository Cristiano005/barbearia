import { createRouter, createWebHistory } from 'vue-router';

import { axiosInstance } from '@/helpers/helper';

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
    {
      path: '/schedules',
      name: 'schedules',
      component: () => import('../views/SchedulesView.vue')
    },
    {
      path: '/services',
      name: 'services',
      component: () => import('../views/ServicesView.vue')
    }
  ]
});

router.beforeEach(async (to, from, next) => {

    try {
        const { data } = await axiosInstance.get("/api/v1/auth/check");
        if(to.name !== "signin" && !data) next({name: "signin"});
        else next();
    } 
    
    catch (error) {
        next();    
    }

});

export default router;