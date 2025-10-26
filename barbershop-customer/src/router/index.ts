import { useUserStore } from "@/stores/user";
import { createRouter, createWebHistory } from "vue-router"

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            name: "home",
            component: () => import("../views/HomeView.vue")
        },
        {
            path: "/schedule",
            name: "schedule",
            component: () => import("../views/ScheduleView.vue"),
            meta: { requiresAuth: true }
        },
        {
            path: "/profile",
            name: "profile",
            component: () => import("../views/ProfileView.vue"),
            meta: { requiresAuth: true }
        },
        {
            path: "/signin",
            name: "signin",
            component: () => import("../views/SignInView.vue"),
            meta: { requiresGuest: true }
        },
        {
            path: "/signup",
            name: "signup",
            component: () => import("../views/SignUpView.vue"),
            meta: { requiresGuest: true }
        },
        {
            path: "/:pathMatch(.*)*",
            name: "notfound",
            component: () => import("../views/NotFoundView.vue")
        },
    ]
})

router.beforeEach(async (to, from, next) => {

    const userStore = useUserStore();
    await userStore.check();

    const isAuthenticated: boolean = userStore.getAuthenticatedStatus;

    if (to.meta.requiresGuest && isAuthenticated) return next({ name: "home" });
    if (to.meta.requiresAuth && !isAuthenticated) return next({ name: "signin" });

    next();
});

export default router