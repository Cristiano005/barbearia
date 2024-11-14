import { axiosInstance } from '@/helpers/helper';
import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import('../views/HomeView.vue')
    },
    {
      path: '/my-schedules',
      name: 'schedules',
      component: () => import('../views/SchedulesView.vue')
    },
    {
      path: '/signin',
      name: 'signin',
      component: () => import('../views/SignInView.vue')
    },
    {
      path: '/signup',
      name: 'signup',
      component: () => import('../views/SignUpView.vue')
    },
  ]
})

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

export default router