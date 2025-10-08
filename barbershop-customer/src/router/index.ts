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
      path: '/schedule',
      name: 'schedule',
      component: () => import('../views/ScheduleView.vue')
    },
    {
      path: '/profile',
      name: 'profile',
      component: () => import('../views/ProfileView.vue')
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
    {
      path: '/:pathMatch(.*)*',
      name: 'notfound',
      component: () => import('../views/NotFoundView.vue')
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